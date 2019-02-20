<?php

namespace App\Http\Controllers\Web;

use Auth;
use Session;
use App\Models\User;
use App\Models\Order;
use Zarinpal\Zarinpal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        return view('profile.payment')->withPaymentMethods(enum('payment'));
    }

    public function store(StorePaymentRequest $request)
    {
        $order_variation = $this->createVariations($user = Auth::user());

        $address = Session::pull('address');
        if ($address === null) {
            return redirect()->route('shipping.index');
        }

        $order = $this->submitOrder($user, $address, $order_variation);

        switch ($method = $request->input('payment')) {
            case $method === enum('payment.zarinpal.key'):
                return $this->payWithZarinpal($order, $user);
                break;
            case $method === enum('payment.pos.key'):
                return $this->payWithPos($user);
                break;
            default:
                return back();
        }
    }

    private function createVariations(User $user): array
    {
        $order_variation = [];
        $user->cart()->with('variation')->get()->each(function ($cart) use (&$order_variation) {
            $order_variation[] = [
                'variation_id' => $cart->variation_id,
                'quantity' => $cart->quantity,
                'price' => $cart->variation->price,
                'options' => json_encode($cart->variation->options),
            ];
        });

        return $order_variation;
    }

    private function submitOrder(User $user, $address, array $order_variation)
    {
        $order = $user->orders()->create(
            $user->addresses()->whereId($address)->first()->toArray()
        );
        $order->variations()->sync($order_variation, false);

        return $order;
    }

    private function payWithZarinpal(Order $order, User $user)
    {
        $transaction = Transaction::create([
            'method' => 'zarinpal',
            'model' => $order,
            'user_id' => Auth::id(),
            'amount' => $user->cartCost,
        ]);
        if ($transaction === null) {
            return back();
        }
        $user->cart()->forceDelete();

        return redirect()->to(env('ZARINPAL').$transaction->options['Authority']);
    }

    private function payWithPos(User $user)
    {
        $user->cart()->forceDelete();

        return redirect()->route('profile.orders')
            ->withCookie(\Cookie::make('cart', null));
    }

    public function verify(Request $request)
    {
        $transaction = Transaction::whereRaw(
            "JSON_EXTRACT(options, '$.Authority') = '{$request->get('Authority')}'")
        ->firstOrFail();
        $transaction->verify(['sandbox' => true]);

        return redirect()->route('profile.orders');
    }
}
