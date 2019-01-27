<?php

namespace App\Repositories;

use DB;
use Throwable;
use App\Models\Product;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository
{
    public function find(int $id) : ?Product
    {
        return Product::find($id);
    }

    public function findByBrand(string $title) : ?Product
    {
        return Product::whereTitle($title)->first();
    }

    public function searchBy(array $columns, string $value) : Collection
    {
        $builder = Product::query();
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
        $productes = QueryBuilder::for(Product::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at']);
        $this->applyParams($productes, $params);

        return $productes->get();
    }

    public function getRecents($number = 10): Collection
    {
        return Product::take($number)->latest()->get();
    }

    public function getBy(string $column, string $value) : Collection
    {
        return QueryBuilder::for(Product::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed() : Collection
    {
        return QueryBuilder::for(Product::query())
            ->allowedFilters(['brand', 'email'])
            ->allowedSorts(['brand', 'city', 'province', 'created_at', 'updated_at'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $product) : ?Product
    {
        try {
            return DB::transaction(function () use ($product) {
                return Product::create($product);
            });
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function update($product, array $data) : ?int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($product instanceof Product) {
                return $product->update($data);
            }

            $ids = is_array($product) ? $product : [$product];

            return  Product::whereIn('id', $ids)->update($data);
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function delete($product) : ?int
    {
        try {
            if ($product instanceof Product) {
                return  $product->delete();
            }

            $ids = is_array($product) ? $product : func_get_args();

            return  Product::whereIn('id', $ids)->delete();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function restore($product) : ?int
    {
        try {
            if ($product instanceof Product) {
                return  $product->restore();
            }

            $ids = is_array($product) ? $product : func_get_args();

            return  Product::whereIn('id', $ids)->restore();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function destroy($product) : ?int
    {
        try {
            if ($product instanceof Product) {
                return  $product->forceDelete();
            }

            $ids = is_array($product) ? $product : func_get_args();

            return Product::whereIn('id', $ids)->forceDelete();
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
