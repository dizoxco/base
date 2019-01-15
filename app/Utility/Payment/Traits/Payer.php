<?php

namespace App\Utility\Payment\Traits;

use App\Utility\Payment\Contracts\IsPayable;
use Illuminate\Validation\Validator;
use InvalidArgumentException;

trait Payer
{
    protected $method;

    private $namespace = 'App\\Utility\\Payment\\Methods\\';

    // ================================ Payment Operates ======================
    public function pay(array $attributes): array
    {
        $payment_method = $this->namespace.ucfirst($attributes['method']);
        $payment_method = new $payment_method;
        $payment_method->setOptions($attributes);
        $v = \Validator::make($attributes, $payment_method->rules());
        if ($v->fails()) {
            throw new InvalidArgumentException($v->errors()->first());
        }
        return $payment_method->execute();
    }

    public function verify()
    {
        $method = $this->getAttribute('method');
        $payment_method = new $method();
        return $payment_method->verify($this);
    }
    // ================================ End Payment Operates ==================

    // ================================ Payment validated and stored ==========
    public static function create(array $attributes = [])
    {
        parent::validateInputs($attributes);

        $options = parent::pay($attributes);

        $model = $options['model']->pays()->create([
            'user_id'   =>  $options['user_id'],
            'amount'    =>  $options['amount'],
            'method'    =>  $options['method'],
            'options'   =>  array_except($options, ['user_id', 'amount', 'method','model'])
        ]);

        return $model;
    }

    public function validateInputs(array $attributes): void
    {
        $v = \Validator::make($attributes, [
            'method' => 'required',
            'model' => 'required',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
        ]);

        $v->after(function (Validator $validator) use ($attributes) {

            $class_base = $this->namespace.ucfirst($attributes['method']);
            if (! class_exists($class_base)) {
                $validator->errors()->add('method' , 'Payment method "'.$attributes['method'].'" not set.');
            }

            if (! $attributes['model'] instanceof IsPayable) {
                $validator->errors()->add('model', 'Model '.get_class($attributes['model']).' is not instance of IsPayable.');
            }
        });

        if ($v->fails()) {
            throw new InvalidArgumentException($v->errors()->first());
        }
    }
    // ================================ Payment validated and stored ==========
}