<?php

namespace App\Http\Controllers\Web;

use Auth;
use Cookie;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->cart()->with('variation', 'variation.product')->get();

        return view('profile.cart', compact('carts'));
    }

    public function store(Request $request, Variation $variation)
    {
        if (Auth::check()) {
            Auth::user()->cart()->updateOrCreate([
                'user_id' => Auth::id(),
                'variation_id' => $variation->id,
                ], [
                    'variation_id' => $variation->id,
                    'quantity' => \DB::raw('quantity + 1'),
                ]);
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

        return redirect()->back()->withCookies([$cookie]);
    }

    public function destroy(Request $request, Variation $variation)
    {
        if (Auth::check()) {
            Auth::user()->cart()->whereUserId(Auth::id())->whereVariationId($variation->id)->delete();

            return redirect()->back();
        } elseif ($cart = json_decode(Cookie::get('cart'), true)) {
            if (array_key_exists($variation->id, $cart)) {
                $cart[$variation->id] -= 1;
            }

            if ($cart[$variation->id] == 0) {
                unset($cart[$variation->id]);
            }

            return redirect()->back()->withCookies([Cookie::make('cart', json_encode($cart))]);
        }
    }
}
