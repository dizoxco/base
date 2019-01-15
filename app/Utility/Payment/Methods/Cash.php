<?php

namespace App\Utility\Payment\Methods;

use App\Utility\Payment\Contracts\PaymentMethod;

class Cash implements PaymentMethod
{
    private $options;

    public function execute(): array
    {
        return $this->options;
    }

    public function rules(): array
    {
        return [
            'sender' => 'required|exists:users,id',
            'receiver' => 'required|exists:users,id',
            'date' => 'required|date',
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
