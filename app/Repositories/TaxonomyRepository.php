<?php

namespace App\Repositories;

use Throwable;
use App\Models\Taxonomy;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class TaxonomyRepository extends BaseRepository
{
    private $model;

    public function __construct()
    {
        $this->model = Taxonomy::query();
    }

    public function getAll($params = []) : Collection
    {
        $taxonomies = QueryBuilder::for($this->model)
            ->allowedFilters(['group_name', 'slug'])
            ->allowedIncludes(['tags'])
            ->allowedSorts(['created_at', 'updated_at']);
        $this->applyParams($taxonomies, $params);

        return $taxonomies->get();
    }

    public function getTrashed() : ?Collection
    {
        return QueryBuilder::for(Taxonomy::query())
            ->allowedFilters(['group_name', 'label', 'slug'])
            ->allowedSorts(['created_at', 'updated_at', 'deleted_at'])
            ->onlyTrashed()
            ->get();
    }    

    public function create(array $data): ?Taxonomy
    {
        try {
            return $this->model->create($data);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function update($taxonomy, array $data): int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($taxonomy instanceof Taxonomy) {
                return $taxonomy->update($data);
            }

            return  $this->model->whereIn('id', array_wrap($taxonomy))->update($data);
        } catch (Throwable $throwable) {
            return 0;
        }
    }

    public function delete($taxonomy)
    {
        try {
            if ($taxonomy instanceof Taxonomy) {
                return  $taxonomy->delete();
            }
            $ids = is_array($taxonomy) ? $taxonomy : func_get_args();

            return  Taxonomy::whereIn('id', $ids)->delete();
        } catch (Exception $exception) {
            return 0;
        }
    }    
}
