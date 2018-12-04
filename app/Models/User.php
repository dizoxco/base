<?php

namespace App\Models;

use Spatie\MediaLibrary\File;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use App\Repositories\Facades\UserRepo;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HttpFoundation\Response;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, SoftDeletes, HasApiTokens, HasRoles, HasMediaTrait;

    protected $perPage  =   2;

    protected $casts    =   [
        'deleted_at'    =>  'datetime',
        'active'        =>  'boolean'
    ];

    protected $fillable =   [
        'google_id', 'name', 'avatar', 'email', 'password', 'active', 'activation_token'
    ];

    protected $hidden   =   [
        'password', 'remember_token', 'activation_token',
    ];

    //  =============================== Accessor ==============================
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->family}";
    }
    //  =============================== End Accessor ==========================

    //  =============================== Relationships =========================
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    //  =============================== End Relationships =====================

    //  =============================== Media =================================

    public function getAvatarAttribute()
    {
        return $this->getFirstMediaUrl(enum('media.user.avatar'));
    }

    public function getMediaGroups()
    {
        return $this->hasManyThrough(
            \Spatie\MediaLibrary\Models\Media::class,
            MediaRelation::class,
            'model_id',
            'id',
            'id',
            'media_id'
        )->getQuery()->where('media_relations.model_type', self::class)->get();
    }

    public function registerMediaCollections()
    {
        //  Register media collection for avatar that only accepts images
        $this->addMediaCollection(enum('media.user.avatar'))
            ->acceptsFile(function (File $file) {
                $allowed_mimes  =   [
                    'image/jpeg','image/png','image/tiff','image/bmp',
                ];
                return in_array($file->mimeType, $allowed_mimes);
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
                'Content-Type' => JSON
            ]
        );
    }
}
