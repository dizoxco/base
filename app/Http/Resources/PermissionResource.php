<?php

namespace App\Http\Resources;

class PermissionResource extends BaseResource
{
    public function toArray($request)
    {
        $relations = $this->getRelations();
        $resource = [
            'type'   =>  'permission',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'guard'             =>  $this->guard_name,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            $this->mergeWhen(isset($relations['roles']) && count($relations['roles']), [
                'relations' => [
                    'roles'             =>  $this->roles->pluck('id'),
                ],
            ]),
        ];

        return $resource;
    }
}
