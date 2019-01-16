<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessCollection;
use App\Repositories\Facades\BusinessRepo;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Businesses\StoreBusinessRequest;
use App\Http\Requests\Businesses\UpdateBusinessRequest;

class BusinessController extends Controller
{
    public function index()
    {
        return new BusinessCollection(BusinessRepo::getAll());
    }

    public function store(StoreBusinessRequest $request)
    {
        // todo:how to save legal or private businesses?
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

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        // todo:if nothing changes, do not perform a query
        $business = BusinessRepo::update($business, $request->all());
        $status = $business === null ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK;

        return (new EffectedRows($business))->response()->setStatusCode($status);
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
