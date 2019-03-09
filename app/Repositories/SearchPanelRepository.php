<?php

namespace App\Repositories;

use App\Models\SearchPanel;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class SearchPanelRepository extends BaseRepository
{
    public function findBySlug(string $slug) : ?SearchPanel
    {
        return SearchPanel::whereSlug($slug)->first();
    }

    public function searchBy(array $columns, string $value) : Collection
    {
        $builder = SearchPanel::query();
        foreach ($columns as $column) {
            $builder->orWhere(
                function ($query) use ($column, $value) {
                    $query->where($column, 'like', '%'.$value.'%');
                }
            );
        }

        return $builder->get();
    }

    public function getAll($params = []) : Collection
    {
        $search_panels = QueryBuilder::for(SearchPanel::query())
            ->allowedFilters(['title', 'slug', 'model'])
            ->allowedSorts(['title', 'slug', 'model']);
        $this->applyParams($search_panels, $params);

        return $search_panels->get();
    }

    public function getBy(string $column, string $value) : Collection
    {
        return QueryBuilder::for(SearchPanel::query())
            ->allowedFilters(['title', 'slug', 'model'])
            ->allowedSorts(['title', 'slug', 'model'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed() : Collection
    {
        return QueryBuilder::for(SearchPanel::query())
            ->allowedFilters(['title', 'slug', 'model'])
            ->allowedSorts(['title', 'slug', 'model'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $data) : ?SearchPanel
    {
        try {
            return SearchPanel::create($data);
        } catch (QueryException $queryException) {
            return null;
        }
    }

    public function update($search_panel, array $data)  :   ?int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($search_panel instanceof SearchPanel) {
                return $search_panel->update($data);
            }

            $ids = is_array($search_panel) ? $search_panel : [$search_panel];

            return  SearchPanel::whereIn('id', $ids)->update($data);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function delete($search_panel) : ?int
    {
        try {
            if ($search_panel instanceof SearchPanel) {
                return  $search_panel->delete();
            }

            $args = is_array($search_panel) ? $search_panel : func_get_args();
            $builder = SearchPanel::query();
            foreach ($args as $arg) {
                if (is_string($arg)) {
                    $builder->whereSlug($arg);
                    continue;
                }
                if (is_int($arg)) {
                    $builder->whereId($arg);
                }
            }

            return  $builder->delete();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function restore($search_panel) : ?int
    {
        try {
            if ($search_panel instanceof SearchPanel) {
                return  $search_panel->restore();
            }
            $args = is_array($search_panel) ? $search_panel : func_get_args();
            return SearchPanel::whereIn('id', $args)->restore();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function destroy($search_panel) : ?int
    {
        try {
            if ($search_panel instanceof SearchPanel) {
                return  $search_panel->forceDelete();
            }

            $args = is_array($search_panel) ? $search_panel : func_get_args();
            $builder = SearchPanel::query();
            foreach ($args as $arg) {
                if (is_string($arg)) {
                    $builder->whereSlug($arg);
                    continue;
                }
                if (is_int($arg)) {
                    $builder->whereId($arg);
                }
            }

            return  $builder->forceDelete();
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
