<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\MediaResource;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    public function update(Request $request, Media $medium)
    {
        if ($updated_medium = $medium->update($request->all())) {
            $status = Response::HTTP_OK;
            $resource = new MediaResource($medium);
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $resource = new EffectedRows($updated_medium);
        }

        return $resource->response()->setStatusCode($status);
    }

    public function destroy(Media $medium)
    {
        if ($deleted_medium = $medium->delete()) {
            $status = Response::HTTP_OK;
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $resource = new EffectedRows($deleted_medium);

        return $resource->response()->setStatusCode($status);
    }
}
