<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\VariationResource;
use App\Http\Resources\VariationCollection;
use App\Repositories\Facades\VariationRepo;
use Symfony\Component\HttpFoundation\Response;

class VariationController extends Controller
{
    public function index(Product $product)
    {
        return new VariationCollection(VariationRepo::getAll($product->id));
    }

    public function store(Request $request, Product $product)
    {
        if ($product->single && $product->relatedVariations()->count() >= 1) {
            // todo:respond with the proper message
            return new EffectedRows(0);
        }

        $variation = VariationRepo::create($request->all(), $product);
        if ($variation === null) {
            return (new EffectedRows($variation))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            return (new VariationResource($variation))->response()->setStatusCode(Response::HTTP_CREATED);
        }
    }

    public function show(Product $product, Variation $variation)
    {
        return new VariationResource($variation);
    }

    public function update(Request $request, Product $product, Variation $variation)
    {
        $product = VariationRepo::update($variation, $request->all());
        $status = $product === null ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK;

        return (new EffectedRows($product))->response()->setStatusCode($status);
    }

    public function delete(Product $product, Variation $variation)
    {
        $resource = new EffectedRows(VariationRepo::delete($variation));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }

    public function restore(Product $product, Variation $variation)
    {
        $resource = new EffectedRows(VariationRepo::restore($variation));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Product $product, Variation $variation)
    {
        $resource = new EffectedRows(VariationRepo::destroy($variation));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }
}
