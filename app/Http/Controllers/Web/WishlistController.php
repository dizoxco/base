<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->wishlist()->with('users')->get();

        return view('profile.wishlist', compact('wishlist'));
    }

    public function store(Request $request, Product $product)
    {
        if (Auth::check()) {
            Auth::user()->wishlist()->toggle($product->id);
            $cookie = Cookie::make('wishlist', null);
        } else {
            if ($wishlist = json_decode(Cookie::get('wishlist'), true)) {
                if (! array_key_exists($product->id, $wishlist)) {
                    $wishlist[$product->id] = 1;
                }

                $cookie = Cookie::make('wishlist', json_encode($wishlist));
            } else {
                $cookie = Cookie::make('wishlist', json_encode([$product->id => 1]));
            }
        }

        return redirect()->back()->withCookies([$cookie]);
    }

    public function destroy(Request $request, Product $product)
    {
        if (Auth::check()) {
            Auth::user()->wishlist()->whereUserId(Auth::id())->whereProductId($product->id)->delete();
        } elseif ($wishlist = json_decode(Cookie::get('wishlist'), true)) {
            if (array_key_exists($product->id, $wishlist)) {
                $wishlist[$product->id] -= 1;
            }

            if ($wishlist[$product->id] == 0) {
                unset($wishlist[$product->id]);
            }

            return redirect()->back()->withCookies([Cookie::make('wishlist', json_encode($wishlist))]);
        }

        return redirect()->back();
    }
}
