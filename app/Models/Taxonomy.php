<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use HasSlug, SoftDeletes;

    /** @var string $table */
    protected $table = 'taxonomies';

    /** @var array $fillable */
    protected $fillable = [
        'slug', 'label', 'group_name',
    ];

    public function tags()
    {
        return $this->hasMany(Tag::class, 'taxonomy_id', 'id');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->usingLanguage('fa')
            ->generateSlugsFrom('group_name')
            ->saveSlugsTo('slug');
    }
}
