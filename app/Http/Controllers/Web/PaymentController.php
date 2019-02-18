<?php

namespace App\Http\Controllers\Web;

use Session;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $payment_methods = [
            'پرداخت انلاین' => 'online',
            'پرداخت در محل' => 'pos',
        ];

        return view('profile.payment', compact('payment_methods'));
    }

    public function store(StorePaymentRequest $request)
    {
        $user = \Auth::user();

        // Convert cart to order_variation
        $order_variation = [];
        $user->cart()->with('variation')->get()->each(function ($cart) use (&$order_variation) {
            $order_variation[] = [
                'variation_id' => $cart->variation_id,
                'quantity' => $cart->quantity,
                'price' => $cart->variation->price,
                'options' => $cart->variation->options,
            ];
        });

        // Submit order with its variations
        $address = Session::pull('address');
        if ($address === null) {
            return redirect()->route('shipping.index');
        }
        $order = $user->orders()->create(
            $user->addresses()->whereId($address)->first()->toArray()
        );
        $order->variations()->sync($order_variation, false);

        // Removes stuff from user's cart and redirect him to next page
        $user->cart()->forceDelete();
        if ($request->input('payment') === 'online') {
            return redirect()->to('https://ib.bpi.ir');
        } else {
            return redirect()->route('profile.orders')
                ->withCookie(\Cookie::make('cart', null));
        }
    }
}
