<?php

namespace App\Models;

use App\Utility\Payment\Traits\Payer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Payer;

    protected $fillable = [
        'payable_id', 'payable_type', 'user_id', 'amount', 'method', 'track_code', 'options',
    ];

    protected $casts = [
        'amount' => 'integer',
        'options' => 'array',
    ];

    public function payable()
    {
        return $this->morphTo();
    }
}
