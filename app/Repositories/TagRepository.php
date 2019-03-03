<?php

namespace App\Repositories;

use Throwable;
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
            ->allowedIncludes(['taxonomy', 'posts', 'products'])
            ->allowedSorts(['created_at', 'updated_at']);
        $this->applyParams($tags, $params);

        return $tags->get();
    }

    public function create(array $data): ?Tag
    {
        try {
            return $this->model->create($data);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function update($tag, array $data): int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($tag instanceof Tag) {
                return $tag->update($data);
            }

            return  $this->model->whereIn('id', array_wrap($tag))->update($data);
        } catch (Throwable $throwable) {
            return 0;
        }
    }
}
