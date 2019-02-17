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
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRoles, HasMediaTrait, HasMediaRelation;

    protected $perPage = 10;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'google_id', 'name', 'email', 'mobile', 'password', 'activation_token',
        'remember_token', 'email_verified_at', 'mobile_verified_at',
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
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function chats() : HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id', 'id')
            ->where('business_id', '<>', 0);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id', 'id')
            ->where('business_id', '=', 0);
    }

    public function businesses() : BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'businesses_users', 'user_id', 'business_id');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
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

    public function orders(): HasMany
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
