<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'parent_id', 'taxonomy_id', 'label', 'slug', 'metadata',
    ];

    public function taxonomy() : BelongsTo
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id');
    }

    public function posts() : MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function products() : MorphToMany
    {
        return $this->morphedByMany(Variation::class, 'taggable');
    }
}
