<?php

namespace App\Http\Controllers\Web;

use Auth;
use Cookie;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\ProductRepo;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['tags', 'media', 'comments', 'relatedVariations', 'users']);
        $recent = ProductRepo::getRecent();
        $related = ProductRepo::getRelated($product);
        if (Auth::check()) {
            $is_favorite = $product->users->pluck('id')->contains(Auth::id());
        } else {
            $is_favorite = array_key_exists(
                $product->id, array_wrap(
                    json_decode(Cookie::get('wishlist'), true)
                )
            );
        }

        return view('web.products.show', compact('product', 'recent', 'related', 'is_favorite'));
    }
}
