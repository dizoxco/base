<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Variation;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\CartCollection;
use App\Http\Requests\Cart\StoreCartRequest;

class CartController extends Controller
{
    public function index()
    {
        return new CartCollection(auth_user()->cart);
    }

    public function store(StoreCartRequest $request)
    {
        $cart = auth_user()->cart()->whereVariationId($request->input('variation_id'));
        if ($cart->exists()) {
            $cart = $cart->first();
            if ($this->validateRequestedQuantity($request, $cart)) {
                $effected_row = $cart->increment('quantity', $request->input('quantity'));

                return new EffectedRows($effected_row);
            } else {
                // todo:respond with a proper message that show user requested more than variation quantity
                return new EffectedRows(0);
            }
        } else {
            return new CartCollection(auth_user()->cart()->create($request->all()));
        }
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user->id === auth_user()->id) {
            return new EffectedRows($cart->delete());
        }
        // todo:response an unauthorized action
        abort(401);
    }

    public function checkout()
    {
        if (auth_user()->address->isEmpty()) {
            return 'address is empty.';
            // todo:add an address
        }
        //todo:shipping methods
        //todo:payment methods
        $address = auth_user()->address->first()->toArray();
        $order = auth_user()->order()->create($address);
        $ordered_variations = [];
        $carts = auth_user()->cart()->with('variation')->get();
        foreach ($carts as $cart) {
            $ordered_variations[] = [
                'variation_id' => $cart->variation_id,
                'price' => $cart->quantity * $cart->variation->price,
                'options' => $cart->variation->options,
            ];
        }

        return $order->variations()->createMany($ordered_variations);
    }

    /**
     * @param StoreCartRequest $request
     * @param $cart
     * @return mixed
     */
    public function validateRequestedQuantity(StoreCartRequest $request, $cart)
    {
        $requested_qty = $cart->quantity + $request->input('quantity');

        $variation = Variation::find($request->input('variation_id'));
        $v = \Validator::make(
            ['quantity' => "$requested_qty"],
            ['quantity' => "integer|between:1,$variation->quantity"]
        );

        return $v->passes();
    }
}
