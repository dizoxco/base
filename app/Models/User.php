<?php

namespace App\Models;

use App\Repositories\Facades\UserRepo;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\HttpFoundation\Response;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRoles;

    const   TYPE        =   'users';

    protected $perPage  =   2;

    protected $casts    =   [
        'deleted_at'    =>  'datetime',
        'active'        =>  'boolean'
    ];

    protected $fillable =   [
        'google_id', 'name', 'email', 'password', 'activation_token', 'active'
    ];

    protected $hidden   =   [
        'password', 'remember_token', 'activation_token',
    ];
    //  =============================== Relationships =========================
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    //  =============================== End Relationships =====================

    public function resolveRouteBinding($user)
    {
        $user   =   UserRepo::find($user);
        return $user !== null ? $user : response(
            [
                'error' => [
                    'not_found' => trans('http.not_found')
                ]
            ],
            Response::HTTP_NOT_FOUND,
            [
                'Content-Type' => enum('json')
            ]
        );
    }
}
