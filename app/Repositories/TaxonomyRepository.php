<?php


namespace App\Repositories;

use App\Models\Taxonomy;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
class TaxonomyRepository extends BaseRepository
{
    public function getAll($params = []) : ?Collection
    {
        $taxonomies = QueryBuilder::for(Taxonomy::query())
            ->allowedFilters(['group_name', 'slug'])
            ->allowedIncludes(['tags'])
            ->allowedSorts(['created_at', 'updated_at']);
        $this->applyParams($taxonomies, $params);

        return $taxonomies->get();
    }

}