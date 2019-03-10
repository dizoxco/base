<?php

namespace App\Http\Resources;

class CityResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'type'   =>  'city',
            'id'     =>  (string) $this->id,
            'attributes'   =>  [
                'name'          =>  $this->name,
                'en_name'       =>  $this->en_name,
                'latitude'      =>  $this->latitude,
                'longitude'     =>  $this->longitude,
                'county_id'     =>  $this->county_id,
                'county_name'   =>  $this->county->name,
                'province_id'   =>  $this->province,
                'province_name' =>  $this->province->name,
                'withCounty'    =>  "{$this->name} - {$this->county->name}",
                'withProvince'  =>  "{$this->name} - {$this->province->name}",
                'fullname'      =>  "{$this->name} - {$this->county->name} - {$this->province->name}",
            ],
            'relations' =>  [
                $this->mergeWhen($this->whenLoaded('county'), [
                    'county' => $this->county->id,
                ]),
                $this->mergeWhen($this->whenLoaded('province'), [
                    'province' => $this->province->id
                ])
            ],
        ];
    }
}
