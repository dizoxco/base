<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
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
}
