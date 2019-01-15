<?php

namespace App\Utility\Payment\Contracts;

interface PaymentMethod
{
    public function rules(): array;

    public function execute(): array;

    public function getOptions(): array;

    public function verify($transaction);

    public function setOptions(array $options) : void;
}
