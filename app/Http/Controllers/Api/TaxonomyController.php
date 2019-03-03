<?php

namespace App\Http\Controllers\Api;

use App\Models\Taxonomy;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\TaxonomyResource;
use App\Http\Resources\TaxonomyCollection;
use App\Repositories\Facades\TaxonomyRepo;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Taxonomy\StoreTaxonomyRequest;
use App\Http\Requests\Taxonomy\UpdateTaxonomyRequest;

class TaxonomyController extends Controller
{
    public function index()
    {
        return new TaxonomyCollection(TaxonomyRepo::getAll([
            'with' => ['tags'],
        ]));
    }

    public function store(StoreTaxonomyRequest $request)
    {
        $created_taxonomy = TaxonomyRepo::create($request->all());
        if ($created_taxonomy === null) {
            return (new EffectedRows($created_taxonomy))
                ->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new TaxonomyResource($created_taxonomy);
    }

    public function update(UpdateTaxonomyRequest $request, Taxonomy $taxonomy)
    {
        $updated_taxonomy = TaxonomyRepo::update($taxonomy, $request->all());
        $status = $updated_taxonomy === null ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK;

        return  (new EffectedRows($updated_taxonomy))->response()->setStatusCode($status);
    }
}
