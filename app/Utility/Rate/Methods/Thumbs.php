<?php

namespace App\Utility\Rate\Methods;

use stdClass as Rating;
use App\Utility\Rate\BaseRate;

class Thumbs extends BaseRate
{
    private $positive;

    private $negative;

    public function __construct($format, $userRate, $result, $data)
    {
        parent::__construct($format, $userRate, $result, $data);

        $this->positive = $this->format['values']['positive'];

        $this->negative = $this->format['values']['negative'];
    }

    protected function firstTime()
    {

        $this->data = new Rating();

        $this->data->users_count = 0;

        $this->data->{$this->positive} = 0;

        $this->data->{$this->negative} = 0;

    }

    protected function updateRate()
    {
        $this->data->users_count += 1;

        if (key_exists($this->positive, $this->request->get($this->format['slug']))) {

            $this->data->{$this->positive} += 1;

        } else if (key_exists($this->negative, $this->request->get($this->format['slug']))) {

            $this->data->{$this->negative} += 1;
        }
        //todo : decide about rate sum for multi Single
        $this->result = $this->data->{$this->positive} - $this->data->{$this->negative};
    }

}