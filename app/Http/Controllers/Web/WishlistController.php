<?php

namespace App\Http\Controllers\Web;

use Auth;
use Cookie;
use Throwable;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $wishlist = auth()->user()->wishlist()->with('users')->get();
        } else {
            $wishlist = array_wrap(json_decode(Cookie::get('wishlist'), true));
            $wishlist = Product::whereHas('relatedVariations', function ($query) use ($wishlist) {
                return $query->whereIn('id', array_keys($wishlist));
            })->get();
        }

        return view('profile.wishlist', compact('wishlist'));
    }

    public function store(Request $request, Product $product)
    {
        if (Auth::check()) {
            try {
                Auth::user()->wishlist()->attach($product->id);
            } catch (Throwable $throwable) {
                return back();
            }
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

        return back()->withCookies([$cookie])->with('side_content', 'wishlist');
    }

    public function destroy(Request $request, Product $product)
    {
        if (Auth::check()) {
            try {
                Auth::user()->wishlist()->detach($product->id);
            } catch (Throwable $throwable) {
                return back();
            }
        } elseif ($wishlist = json_decode(Cookie::get('wishlist'), true)) {
            if (array_key_exists($product->id, $wishlist)) {
                $wishlist[$product->id] -= 1;

                if ($wishlist[$product->id] == 0) {
                    unset($wishlist[$product->id]);
                }
            }

            return back()
                ->withCookies([Cookie::make('wishlist', json_encode($wishlist))])
                ->with('side_content', 'wishlist');
        }

        return back()->with('side_content', 'wishlist');
    }
}
