<?php

namespace App\Repositories;

use DB;
use Throwable;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

class VariationRepository extends BaseRepository
{
    public function find(int $id) : ?Variation
    {
        return Variation::find($id);
    }

    public function findByQty(string $quantity) : ?Collection
    {
        return Variation::whereQuantity($quantity)->get();
    }

    public function findByOption(string $quantity) : ?Collection
    {
        // todo:make this happen
        return null;
    }

    public function searchBy(array $columns, string $value) : Collection
    {
        $builder = Variation::query();
        foreach ($columns as $column) {
            $builder->orWhere(
                function ($query) use ($column, $value) {
                    $query->where($column, 'like', '%'.$value.'%');
                }
            );
        }

        return $builder->get();
    }

    public function getAll(int $prodcut, $params = []) : Collection
    {
        $variation = QueryBuilder::for(Variation::query())
            ->allowedFilters(['business_id', 'product_id', 'quantity', 'options'])
            ->allowedSorts(['quantity', 'created_at', 'updated_at']);
        $this->applyParams($variation, $params);

        return $variation->whereProductId($prodcut)->get();
    }

    public function getBy(string $column, string $value) : Collection
    {
        return QueryBuilder::for(Variation::query())
            ->allowedFilters(['business_id', 'product_id', 'quantity', 'options'])
            ->allowedSorts(['quantity', 'created_at', 'updated_at'])
            ->where($column, '=', $value)
            ->get();
    }

    public function getTrashed() : Collection
    {
        return QueryBuilder::for(Variation::query())
            ->allowedFilters(['business_id', 'product_id', 'quantity', 'options'])
            ->allowedSorts(['quantity', 'created_at', 'updated_at'])
            ->onlyTrashed()
            ->get();
    }

    public function create(array $variation, Product $product) : ?Variation
    {
        try {
            return DB::transaction(function () use ($variation, $product) {
                $variation = array_merge($variation, ['business_id' => 1]);

                return $product->variations()->create($variation);
                // todo:this variation belongs to which businesses?
            });
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function update($variation, array $data) : ?int
    {
        if (empty($data)) {
            return 0;
        }

        try {
            if ($variation instanceof Variation) {
                return $variation->update($data);
            }

            $ids = is_array($variation) ? $variation : [$variation];

            return  Variation::whereIn('id', $ids)->update($data);
        } catch (Throwable $throwable) {
            dd($throwable->getMessage());

            return null;
        }
    }

    public function delete($variation) : ?int
    {
        try {
            if ($variation instanceof Variation) {
                return  $variation->delete();
            }

            $ids = is_array($variation) ? $variation : func_get_args();

            return  Variation::whereIn('id', $ids)->delete();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function restore($variation) : ?int
    {
        try {
            if ($variation instanceof Variation) {
                return  $variation->restore();
            }

            $ids = is_array($variation) ? $variation : func_get_args();

            return  Variation::whereIn('id', $ids)->restore();
        } catch (Throwable $throwable) {
            return null;
        }
    }

    public function destroy($variation) : ?int
    {
        try {
            if ($variation instanceof Variation) {
                return  $variation->forceDelete();
            }

            $ids = is_array($variation) ? $variation : func_get_args();

            return Variation::whereIn('id', $ids)->forceDelete();
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
