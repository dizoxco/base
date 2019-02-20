<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Session;

class PaymentController extends Controller
{
    public function index()
    {
        return view('profile.payment')->withPaymentMethods(enum('payment'));
    }

    public function store(StorePaymentRequest $request)
    {
        $order_variation = $this->createVariationsFromCart($user = Auth::user());

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
                return $this->payWithPos($order, $user);
                break;
            default:
                return back();
        }
    }

    /**
     * Prepare selected variations to store in the database
     *
     * @param User $user
     * @return array
     */
    private function createVariationsFromCart(User $user): array
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

    /**
     * Save items ordered by the user in the database
     *
     * @param User $user
     * @param int $address
     * @param array $order_variation
     * @return Order
     */
    private function submitOrder(User $user, int $address, array $order_variation): Order
    {
        $order = $user->orders()->create(
            $user->addresses()->whereId($address)->first()->toArray()
        );
        $order->variations()->sync($order_variation, false);

        return $order;
    }

    /**
     * Save type and amount of transaction and redirect user to payment page
     *
     * @param Order $order
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function payWithZarinpal(Order $order, User $user)
    {
        $transaction = $this->createTransaction('zarinpal', $order, $user);
        if ($transaction === null) {
            return back()->withErrors(['transaction' => 'fail']);
        } else {
            return redirect()->to(env('ZARINPAL').$transaction->options['Authority']);
        }
    }

    /**
     * Save the transaction type and amount
     * Redirect the user to the order details page
     *
     * @param Order $order
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function payWithPos(Order $order, User $user)
    {
        $transaction = $this->createTransaction('pos', $order, $user);
        if ($transaction === null) {
            return back()->withErrors(['transaction' => 'fail']);
        } else {
            return redirect()->route('profile.orders.show', $order);
        }
    }

    /**
     * Save the transaction in the database and return its model
     * Empty user cart
     *
     * @param string $method
     * @param Order $order
     * @param User $user
     * @return Transaction|null
     */
    private function createTransaction(string $method, Order $order, User $user)
    {
        $transaction = Transaction::create([
            'method' => $method,
            'model' => $order,
            'user_id' => Auth::id(),
            'amount' => $user->cartCost,
        ]);
        $user->cart()->forceDelete();
        return $transaction;
    }

    public function verify(Request $request)
    {
        $transaction = Transaction::whereRaw(
            "JSON_EXTRACT(options, '$.Authority') = '{$request->get('Authority')}'")
        ->firstOrFail();
        $transaction->verify(['sandbox' => true]);

        return redirect()->route('profile.orders.show', $transaction->payable);
    }
}
