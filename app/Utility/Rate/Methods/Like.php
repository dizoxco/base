<?php

namespace App\Utility\Rate\Methods;

use stdClass as Rating;
use App\Utility\Rate\BaseRate;

class Like extends BaseRate
{

    protected function firstTime()
    {
        $this->data = new Rating();

        $this->data->users_count = 0;

        $this->data->{$this->format['values']['key']} = 0;

        $this->result = 0;
    }

    protected function updateRate()
    {
        $this->data->users_count += 1;

        $this->data->{$this->format['values']['key']} += 1;

        $this->result = $this->data->{$this->format['values']['key']};
    }
}