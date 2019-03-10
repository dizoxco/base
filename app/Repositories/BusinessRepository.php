<?php

namespace App\Repositories;

use DB;
use Throwable;
use App\Models\Business;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class BusinessRepository extends BaseRepository
{
    public function find(int $id) : ?Business
    {
        return Business::find($id);
    }

    public function findByBrand(string $brand) : ?Business
    {
        return Business::whereBrand($brand)->first();
    }

    public function findBySlug(string $slug) : ?Business
    {
        return Business::whereslug($slug)->first();
    }

    public function searchBy(array $columns, string $value) : Collection
    {
        $builder = Business::query();
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
        $businesses = QueryBuilder::for(Business::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at']);
        $this->applyParams($businesses, $params);

        return $businesses->get();
    }

    public function getRecent($number = 10): Collection
    {
        return Business::take($number)->latest()->get();
    }

    public function getBy(string $column, string $value) : Collection
    {
        return QueryBuilder::for(Business::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed() : Collection
    {
        return QueryBuilder::for(Business::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $business) : ?Business
    {
        try {
            return DB::transaction(function () use ($business) {
                return \Auth::user()->businesses()->create($business);
            });
        } catch (Throwable $throwable) {
            // todo:log the exception or even better send them to bugsnag
            return null;
        }
    }

    public function update($business, array $data) : ?int
    {
        if (empty($data)) {
            return null;
        }

        try {
            if ($business instanceof Business) {
                return $business->update($data);
            }

            $ids = is_array($business) ? $business : [$business];

            return  Business::whereIn('id', $ids)->update($data);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function delete($business) : ?int
    {
        try {
            if ($business instanceof Business) {
                return  $business->delete();
            }

            $ids = is_array($business) ? $business : func_get_args();

            return  Business::whereIn('id', $ids)->delete();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function restore($business) : ?int
    {
        try {
            if ($business instanceof Business) {
                return  $business->restore();
            }

            $ids = is_array($business) ? $business : func_get_args();

            return  Business::whereIn('id', $ids)->restore();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function destroy($business) : ?int
    {
        try {
            if ($business instanceof Business) {
                $business->users()->detach();

                return  $business->forceDelete();
            }

            $ids = is_array($business) ? $business : func_get_args();
            $businesses = Business::whereIn('id', $ids)->get();
            $counter = 0;
            foreach ($businesses as $business) {
                $business->users()->detach();
                $counter += $business->forceDelete();
            }

            return $counter;
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
