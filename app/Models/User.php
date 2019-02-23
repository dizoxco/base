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

    public function getCartCostAttribute()
    {
        $carts = $this->cart()->with('variation')->get();
        $total = 0;
        foreach ($carts as $item) {
            $total += $item->quantity * $item->variation->price;
        }

        return $total;
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

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'businesses_users', 'user_id', 'business_id');
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
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
            ->crop('crop-center', 150, 150)
            ->performOnCollections(enum('media.user.avatar'));
    }

    //  =============================== End Media =============================

    //  =============================== Complementary Methods =================
    public function resolveRouteBinding($user)
    {
        return UserRepo::find($user);
    }

    public function hasVerified(string $column)
    {
        if ($this->{$column.'_verified_at'}) {
            return true;
        }

        return false;
    }

    public function hasNotVerified(string $column)
    {
        return ! $this->hasVerified($column);
    }

    public function hasBusiness($count = 1)
    {
        return $this->businesses->isNotEmpty();
    }

    //  =============================== End Complementary Methods =============
}
