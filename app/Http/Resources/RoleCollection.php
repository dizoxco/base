<?php

namespace App\Http\Resources;

class RoleCollection extends BaseCollection
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
                        case 'permissions':
                            $this->includes[$relation][$item->id] = new PermissionResource($item);
                            break;
                    }
                }
            }

            return (new RoleResource($role))->additional($this->additional);
        });

        return parent::toArray($request);
    }
}
