<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\HttpFoundation\Response;

class EffectedRows extends Resource
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
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setContent(json_encode(
                [
                    'message' => trans('http.internal_err'),
                ]
            ))
            ->header('Content-Type', enum('system.response.json'));
    }
}
