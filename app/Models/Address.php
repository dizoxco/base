<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
      'user_id', 'receiver', 'mobile', 'city', 'address', 'postal_code',
    ];

    //  =============================== Relationships =========================
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //  =============================== End Relationships =====================
}
