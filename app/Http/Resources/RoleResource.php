<?php

namespace App\Http\Resources;

class RoleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $relations = $this->getRelations();
        $resource = [
            'type'   =>  'role',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'guard'             =>  $this->guard_name,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            $this->mergeWhen(isset($relations['permissions']) && count($relations['permissions']), [
                'relations' => [
                    'permissions'             =>  $this->permissions->pluck('id'),
                ],
            ]),
        ];

        return $resource;
    }
}
