<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($role) {
            foreach ($role->getRelations() as $relation => $items) {
                foreach ($items as $item) {
                    switch ($relation) {
                        case 'roles':
                            $this->includes[$relation][$item->id] = new RoleResource($item);
                            break;
                    }
                }
            }
            return (new PermissionResource($role))->additional($this->additional);
        });
        return parent::toArray($request);
    }
}
