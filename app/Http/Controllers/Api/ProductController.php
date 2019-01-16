<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Repositories\Facades\ProductRepo;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return new ProductCollection(ProductRepo::getAll());
    }

    public function store(StoreProductRequest $request)
    {
        $product = ProductRepo::create($request->all());
        if ($product === null) {
            return (new EffectedRows($product))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
        }
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = ProductRepo::update($product, $request->all());
        $status = $product === null ? Response::HTTP_INTERNAL_SERVER_ERROR : Response::HTTP_OK;

        return (new EffectedRows($product))->response()->setStatusCode($status);
    }

    public function delete(Product $product)
    {
        $resource = new EffectedRows(ProductRepo::delete($product));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }

    public function restore(string $product)
    {
        $resource = new EffectedRows(ProductRepo::restore($product));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(string $product)
    {
        $resource = new EffectedRows(ProductRepo::destroy($product));

        return $resource->response()->setStatusCode(Response::HTTP_OK);
    }
}
