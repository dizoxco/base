<?php

namespace App\Utility\Rate;

use Illuminate\Http\Request;

abstract class BaseRate
{
    protected $format;

    protected $request;

    protected $result;

    protected $data;

    public function __construct(array $format, Request $request, $result, $data)
    {
        $this->format = $format;
        $this->request = $request;
        $this->result = $result;
        $this->data = $data;
    }

    public function calculate()
    {
        if (empty($this->data)) {
            $this->firstTime();
        }

        $this->updateRate();

        return $this;
    }

    public function getRateResult()
    {
        return $this->result;
    }

    public function getRateData()
    {
        return $this->data;
    }

    abstract protected function firstTime();

    abstract protected function updateRate();
}
