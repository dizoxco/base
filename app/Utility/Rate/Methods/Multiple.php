<?php

namespace App\Utility\Rate\Methods;

use stdClass as Rating;
use App\Utility\Rate\BaseRate;

class Multiple extends BaseRate
{

    public function __construct($format, $request, $rate, $data)
    {
        parent::__construct($format, $request, $rate, $data);

        $this->request = $this->request->get($this->format['slug'],[]);
    }

    protected function firstTime()
    {
        $this->data = new Rating();

        $this->result = new Rating();

        $this->data->users_count = 0;

        $this->result->total_rate = 0;

        foreach ($this->format['values'] as $item){

            $this->data->{$item} = 0;

            $this->result->{$item} = 0;
        }
    }

    protected function updateRate()
    {

        $this->data->users_count += 1;

        $this->result->total_rate = 0;

        foreach ($this->format['values'] as $item){

            $this->data->{$item} += key_exists($item , $this->request) ? $this->request[$item] : 0;

            $this->result->{$item} =  $this->data->{$item}  / $this->data->users_count;

            $this->result->total_rate += $this->result->{$item};
        }

        $this->result->total_rate /= count($this->format['values']);
    }
}