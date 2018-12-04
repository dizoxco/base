<?php

namespace App\Repositories;

use App\Models\MediaGroup;
use Illuminate\Database\QueryException;
use Spatie\QueryBuilder\QueryBuilder;

class MediaGroupRepository
{
    const NO_ROWS_AFFECTED = 0;

    public function find(int $id)   :   ?MediaGroup
    {
        return MediaGroup::find($id);
    }

    public function findByName(string $name)  :   ?MediaGroup
    {
        return MediaGroup::whereName($name)->first();
    }

    public function getAll($params = [])    :   Collection
    {
        $mediaGroups    =   QueryBuilder::for(MediaGroup::query())
            ->allowedFilters(['name'])
            ->allowedIncludes('files')
            ->allowedSorts(['name', 'created_at', 'updated_at',]);
        $this->applyParams($mediaGroups, $params);
        return $mediaGroups->get();
    }

    public function getBy(string $column, string $value)  :   Collection
    {
        return QueryBuilder::for(MediaGroup::query())
            ->allowedFilters(['name'])
            ->allowedIncludes('files')
            ->allowedSorts(['name', 'created_at', 'updated_at',])
            ->where($column, '=', $value)
            ->get();
    }

    public function create(array $data)
    {
        try {
            return MediaGroup::create($data);
        } catch (QueryException $queryException) {
            return self::NO_ROWS_AFFECTED;
        }
    }

    public function update($mediaGroup, array $data)  :   int
    {
        if (empty($data)) {
            return self::NO_ROWS_AFFECTED;
        }

        if ($mediaGroup instanceof MediaGroup) {
            return $mediaGroup->update($data);
        }
        $ids    =   is_array($mediaGroup)? $mediaGroup: [$mediaGroup];
        return  MediaGroup::whereIn('id', $ids)->update($data);
    }

    public function destroy($mediaGroup)
    {
        try {
            if ($mediaGroup instanceof MediaGroup) {
                return  $mediaGroup->forceDelete();
            }

            $ids    =   is_array($mediaGroup) ? $mediaGroup : func_get_args();
            return  MediaGroup::whereIn('id', $ids)->forceDelete();

        } catch (Exception $exception) {
            return self::NO_ROWS_AFFECTED;
        }
    }
}
