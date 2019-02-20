<?php

namespace App\Utility\Payment\Traits;

use DB;
use InvalidArgumentException;
use Illuminate\Validation\Validator;
use App\Utility\Payment\Contracts\IsPayable;

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

    public function verify(array $options = [])
    {
        $method = $this->getAttribute('method');
        $payment_method = new $method();
        if (! empty($options)) {
            $result = $payment_method->verify($this, extract($options));
        }
        $result = $payment_method->verify($this);
        $this->options = array_merge($this->options, $result);

        return $this->saveOrFail();
    }

    // ================================ End Payment Operates ==================

    // ================================ Payment validated and stored ==========
    public static function create(array $attributes = [])
    {
        try {
            parent::validateInputs($attributes);

            $options = parent::pay($attributes);

            $model = DB::transaction(function () use ($options) {
                return $options['model']->pays()->create([
                    'user_id'   =>  $options['user_id'],
                    'amount'    =>  $options['amount'],
                    'method'    =>  $options['method'],
                    'options'   =>  array_except($options, ['user_id', 'amount', 'method', 'model']),
                ]);
            });

            return $model;
        } catch (\Throwable $throwable) {
            return;
        }
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
                $validator->errors()->add('method', 'Payment method "'.$attributes['method'].'" not set.');
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
