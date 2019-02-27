<?php

namespace App\Http\Resources;

class SearchPanelCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($searchpanel) {
            return (new SearchPanelResource($searchpanel))->additional($this->additional);
        });

        return parent::toArray($request);
    }
}
