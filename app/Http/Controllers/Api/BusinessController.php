<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessCollection;
use App\Repositories\Facades\BusinessRepo;
use Symfony\Component\HttpFoundation\Response;

class BusinessController extends Controller
{
    public function index() 
    {
        return new BusinessCollection(BusinessRepo::getAll());
    }

    public function store(Request $request)
    {
        $business = BusinessRepo::create($request->all());
        if ($business === null) {
            return (new EffectedRows($business))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            return (new BusinessResource($business))->response()->setStatusCode(Response::HTTP_CREATED);
        }
    }

    public function show(Business $business)
    {
        return new BusinessResource($business);
    }

    public function update(Business $business)
    {
        $rows = BusinessRepo::update($business, request()->all());
//        $status = $business === null ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK;

        return new BusinessResource($business);
    }

    public function delete(Business $business)
    {
        return new EffectedRows(BusinessRepo::delete($business));
    }

    public function restore(string $business)
    {
        return new EffectedRows(BusinessRepo::restore($business));
    }

    public function destroy(string $business)
    {
        return new EffectedRows(BusinessRepo::destroy($business));
    }
}
