<?php

namespace App\Utility\Payment\Methods;

use Zarinpal\Zarinpal as ZarinpalGateway;
use App\Utility\Payment\Contracts\PaymentMethod;

class Zarinpal implements PaymentMethod
{
    private $options;

    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:1',
        ];
    }

    public function execute(): array
    {
        $zarinpal = new ZarinpalGateway(config('gateway.zarinpal.merchant-id'));
        $zarinpal->enableSandbox(); // active sandbox mod for test env
        $results = $zarinpal->request(
            config('gateway.zarinpal.callback-url'),
            $this->options['amount'],
            config('gateway.zarinpal.description')
        );
        $this->options['Authority'] = $results['Authority'];
        $this->options['method'] = self::class;

        return $this->options;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function verify($transaction, $sandbox = false)
    {
        $zarinpal = new ZarinpalGateway(config('gateway.zarinpal.merchant-id'));
        if ($sandbox) {
            $zarinpal->enableSandbox();
        }

        return $zarinpal->verify($transaction->amount, $transaction->options['Authority']);
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
