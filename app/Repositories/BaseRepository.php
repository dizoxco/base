<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository
{
    protected function applyParams(&$builder, $params)
    {
        if (!empty($params['with'])) {
            $builder->with($params['with']);
        }
    }
}
