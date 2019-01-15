<?php

namespace App\Utility\Payment\Methods;

use App\Utility\Payment\Contracts\PaymentMethod;
use Larabookir\Gateway\Gateway;
use Larabookir\Gateway\Mellat\Mellat as MellatGateway;

class Mellat implements PaymentMethod
{

    private $options;

    public function rules(): array
    {
        return [
            'amount' => 'required|min:1'
        ];
    }

    public function execute(): array
    {
        $mellat = Gateway::make(0);
        $mellat->setCallback(config('gateway.mellat.callback-url'));
        $mellat->price($this->options['amount'])->ready();
        $this->options['ref_id'] = $mellat->refId();
        $this->options['trans_id'] = $mellat->transactionId();
        return $this->options;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function verify($transaction)
    {
        try {
            $gateway = new MellatGateway();
            $result = $gateway->verify($transaction);
            return $result instanceof MellatGateway;
        } catch (\Throwable $throwable) {
            return $throwable;
        }
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
