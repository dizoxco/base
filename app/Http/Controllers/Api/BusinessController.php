<?php

namespace App\Http\Controllers\Api;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessCollection;
use App\Repositories\Facades\BusinessRepo;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Business\StoreBusinessRequest;
use App\Http\Requests\Business\UpdateBusinessRequest;

class BusinessController extends Controller
{
    public function index()
    {
        return new BusinessCollection(BusinessRepo::getAll(['with' => 'users']));
    }

    public function trash()
    {
        return new BusinessCollection(BusinessRepo::getTrashed());
    }

    public function store(StoreBusinessRequest $request)
    {
        if ($business = BusinessRepo::create($request->except('users'))) {
            $business->users()->sync($request->users);
            return (new BusinessResource($business))->response()->setStatusCode(Response::HTTP_CREATED);
        }

        return new EffectedRows($business);
    }

    public function show(Business $business)
    {
        return new BusinessResource($business);
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        if ($updated_business = BusinessRepo::update($business, $request->except('users'))) {
            $business->users()->sync($request->users);
            return new BusinessResource($business);
        }

        return new EffectedRows($business);
    }

    public function delete(Business $business)
    {
        if ($deleted_business = BusinessRepo::delete($business)) {
            return (new EffectedRows($deleted_business))->response()
                ->setStatusCode(Response::HTTP_OK)
                ->setContent(json_encode([
                    'message' => trans('http.ok'),
                    'errors' => [
                        'ok' => trans('http.ok'),
                    ],
                ]));
        }

        return new EffectedRows($deleted_business);
    }

    public function restore(string $business)
    {
        if ($restored_business = BusinessRepo::restore($business)) {
            return (new EffectedRows($restored_business))->response()
                ->setStatusCode(Response::HTTP_OK)
                ->setContent(json_encode([
                    'message' => trans('http.ok'),
                    'errors' => [
                        'ok' => [trans('http.ok')],
                    ],
                ]));
        }

        return new EffectedRows($restored_business);
    }

    public function destroy(string $business)
    {
        return new EffectedRows(BusinessRepo::destroy($business));
    }
}
