<?php

namespace App\Utility\Rate\Methods;

use stdClass as Rating;
use App\Utility\Rate\BaseRate;

class Stars extends BaseRate
{
    public function firstTime()
    {
        $this->data = new Rating();

        $this->data->users_count = 0;

        $this->data->{$this->format['values']['key']} = 0;

        $this->result = 0;
    }

    public function updateRate()
    {
        $this->data->users_count += 1;

        $this->data->{$this->format['values']['key']} += $this->request->get($this->format['slug']);
        $this->data->star += $this->request->get(star);

        $this->result = $this->data->{$this->format['values']['key']} / $this->data->users_count;
    }
}
