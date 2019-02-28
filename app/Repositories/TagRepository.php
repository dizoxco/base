<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class TagRepository extends BaseRepository
{
    private $model;

    public function __construct()
    {
        $this->model = Tag::query();
    }

    public function getAll($params = []) : Collection
    {
        $tags = QueryBuilder::for($this->model)
            ->allowedFilters(['slug', 'label'])
            ->allowedSorts(['created_at', 'updated_at']);
        $this->applyParams($tags, $params);

        return $tags->get();
    }
}
