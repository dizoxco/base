<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpFoundation\Response;

class DBResource extends Resource
{
    public function toArray($request)
    {
        return [
            'row-effected' => (int) $this->resource,
        ];
    }

    public function withResponse($request, $response)
    {
        $response
            ->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->header('Content-Type', enum('system.response.json'));
    }
}
