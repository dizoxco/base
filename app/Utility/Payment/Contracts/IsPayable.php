<?php

namespace App\Utility\Payment\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface IsPayable
{
    // create a new payment for specific model in transactions table
    public function pays() : MorphMany;
}