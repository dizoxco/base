<?php

namespace App\Models;

use Spatie\MediaLibrary\File;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\Models\Media;
use App\Repositories\Facades\UserRepo;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRoles, HasMediaTrait, HasMediaRelation;

    protected $perPage = 2;

    protected $casts = [
        'deleted_at'    =>  'datetime',
        'active'        =>  'boolean',
    ];

    protected $fillable = [
        'google_id', 'name', 'avatar', 'email', 'password', 'active', 'activation_token',
    ];

    protected $hidden = [
        'password', 'remember_token', 'activation_token',
    ];

    //  =============================== Accessor ==============================
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->family}";
    }

    //  =============================== End Accessor ==========================

    //  =============================== Relationships =========================
    public function address(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function avatar() : MorphOne
    {
        return $this->morphOne(Media::class, 'model');
    }

    public function chats() : BelongsToMany
    {
        return $this->belongsToMany(
            Chat::class,
            'chat_users',
            'user_id'
        )->where('chats.type', '=', enum('chat.type.chat'));
    }

    public function tickets() : BelongsToMany
    {
        return $this->belongsToMany(
            Chat::class,
            'chat_users',
            'user_id'
        )->where('chats.type', '=', enum('chat.type.ticket'));
    }

    public function businesses() : BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'businesses_users', 'user_id', 'business_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function hasChatWith(int $userId) : bool
    {
        // fixme:equal to
        // "select user_id from chat_users where chat_id in
        //  (SELECT chat_id FROM `chat_users` WHERE chat_users.user_id = $this->id)
        //  and user_id = $userId"
        return $this->chats()->whereHas('users', function ($query) {
            $query->where('user_id', '=', $this->id);
        })->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->whereType(enum('chat.type.chat'))
            ->exists();
    }

    public function getChatWith(int $userId) : Chat
    {
        return $this->chats()->whereHas('users', function ($query) {
            $query->where('user_id', '=', $this->id);
        })->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->whereType(enum('chat.type.chat'))->first();
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    //  =============================== End Relationships =====================

    //  =============================== Media =================================

    public function registerMediaCollections()
    {
        //  Register media collection for avatar that only accepts images
        $this->addMediaCollection(enum('media.user.avatar'))
            ->acceptsFile(function (File $file) {
                $allowedMimes = [
                    'image/jpeg', 'image/png', 'image/tiff', 'image/bmp',
                ];

                return in_array($file->mimeType, $allowedMimes);
            })
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->nonQueued()
            ->performOnCollections(enum('media.user.avatar'));
    }

    //  =============================== End Media =============================
    //  =============================== Complementary Methods =================
    public function resolveRouteBinding($user)
    {
        return UserRepo::find($user);
    }

    //  =============================== End Complementary Methods =============
}
