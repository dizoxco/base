<?php

namespace App\Utility\Payment\Methods;

use App\Utility\Payment\Contracts\PaymentMethod;

class Card implements PaymentMethod
{
    private $options;

    public function execute(): array
    {
        return $this->options;
    }

    public function verify($transaction)
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_number' => 'required', // شناسه قبض
            'date' => 'required|date', // تاریخ
            'origin_card' => 'required|min:16', // کارت مبدا
            'destination_card' => 'required|min:16', // کارت مقصد
            'reference_number' => 'required', // شماره مرجع
            'track_number' => 'required|min:6', // شماره پیگیری
            'doc_id' => 'required', // شناسه سند
            'bill_id' => 'required|min:7', // شناسه قبض
        ];
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
