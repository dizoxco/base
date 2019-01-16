<?php

namespace App\Utility\Payment\Traits;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Payable
{
    public function pays() : MorphMany
    {
        return $this->morphMany(Transaction::class, 'payable');
    }
}
