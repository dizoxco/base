<?php

namespace App\Http\Controllers\Web;

use Auth;
use Cookie;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cart = auth()->user()->cart()->with('variation.product')->get()->pluck('variation');
        } else {
            $cart = array_wrap(json_decode(Cookie::get('cart'), true));
            $cart = Variation::whereIn('id', array_keys($cart))->get();
        }

        return view('profile.cart', compact('cart'));
    }

    public function store(Request $request, Variation $variation)
    {
        if (Auth::check()) {
            Auth::user()->cart()->updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'variation_id' => $variation->id,
                ],
                [
                    'variation_id' => $variation->id,
                    'quantity' => \DB::raw('quantity + 1'),
                ]
            );
            $cookie = Cookie::make('cart', null);
        } else {
            if ($cart = json_decode(Cookie::get('cart'), true)) {
                if (array_key_exists($variation->id, $cart)) {
                    $cart[$variation->id] += 1;
                } else {
                    $cart[$variation->id] = 1;
                }

                $cookie = Cookie::make('cart', json_encode($cart));
            } else {
                $cookie = Cookie::make('cart', json_encode([$variation->id => 1]));
            }
        }

        return back()->withCookies([$cookie])->with('side_content', 'cart');
    }

    public function destroy(Request $request, Variation $variation)
    {
        if (Auth::check()) {
            try {
                Auth::user()->cart()->whereUserId(Auth::id())->whereVariationId($variation->id)->delete();
            } catch (\Throwable $throwable) {
                return back();
            }
        } elseif ($cart = json_decode(Cookie::get('cart'), true)) {
            if (array_key_exists($variation->id, $cart)) {
                $cart[$variation->id] -= 1;

                if ($cart[$variation->id] == 0) {
                    unset($cart[$variation->id]);
                }
            }

            return back()
                ->withCookies([Cookie::make('cart', json_encode($cart))])
                ->with('side_content', 'cart');
        }

        return back()->with('side_content', 'cart');
    }
}
