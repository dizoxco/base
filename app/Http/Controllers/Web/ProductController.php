<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\ProductRepo;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $recent = ProductRepo::getRecent();
        $related = ProductRepo::getRelated($product);

        return view('products.show', compact('product', 'recent', 'related'));
    }
}
