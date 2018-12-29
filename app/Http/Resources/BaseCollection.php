<?php

namespace App\Http\Resources;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseCollection extends ResourceCollection
{
    protected $includes = [];

    public function with($request)
    {
        return empty($this->includes) ? [] : ['included' => $this->includes];
    }

    public function withResponse($request, $response)
    {
        $response
            ->setStatusCode(Response::HTTP_OK)
            ->header('Content-Type', enum('system.response.json'));
    }
}
