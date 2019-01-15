<?php

namespace App\Utility\Payment\Methods;

use App\Utility\Payment\Contracts\PaymentMethod;

class Pos implements PaymentMethod
{
    private $options;

    public function execute(): array
    {
        return $this->options;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:1',
        ];
    }

    public function verify($transaction)
    {
        return true;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}
