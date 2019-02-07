<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\ProductRepo;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['tags', 'media', 'comments', 'relatedVariations']);
        $recent = ProductRepo::getRecent();
        $related = ProductRepo::getRelated($product);

        return view('web.products.show', compact('product', 'recent', 'related'));
    }
}
