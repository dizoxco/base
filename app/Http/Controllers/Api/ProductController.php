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

    public function trash()
    {
        return new ProductCollection(ProductRepo::getTrashed());
    }

    public function store(StoreProductRequest $request)
    {
        $created_product = ProductRepo::create($request->all());
        if ($created_product === null) {
            return (new EffectedRows($created_product))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return (new ProductResource($created_product))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = \DB::transaction(function () use ($product, $request) {
            ProductRepo::update($product, $request->except('tags'));
            $product->tags()->sync($request->tags);

            return $product;
        });

        if ($updated) {
            return new ProductResource($product);
        }

        return new EffectedRows();
    }

    public function delete(Product $product)
    {
        if ($deleted_product = ProductRepo::delete($product)) {
            return (new EffectedRows($deleted_product))->response()
                ->setStatusCode(Response::HTTP_OK)
                ->setContent(json_encode([
                    'message' => trans('http.ok'),
                    'errors' => [
                        'ok' => [trans('http.ok')],
                    ],
                ]));
        }

        return new EffectedRows($deleted_product);
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
