<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{

    public function toArray($request)
    {
        return [
            'type'   =>  'user',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'              =>  $this->name,
                'email'             =>  $this->email,
                'created_at'        =>  $this->when($this->created_at, $this->created_at->timestamp),
                'updated_at'        =>  $this->when($this->updated_at, $this->updated_at->timestamp),
            ],
            // 'relationships'   =>  new UsersRelationshipResource($this),
            'links'      =>  [
                'self'       =>  route('api.users.show', ['user' =>  $this->id]),
            ],
        ];
    }
}
