<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProductRequest;
use App\Models\Business;
use App\Models\Product;

class ProductManagementController extends Controller
{
    public function products(Business $business)
    {
        $products = $business->load('products')->products;

        return view('profile.businesses.products', compact('business', 'products'));
    }

    public function showProduct(Business $business, Product $product)
    {
        return view('profile.businesses.products.show', compact('product', 'business'));
    }

    public function updateProduct(Business $business, Product $product, UpdateProductRequest $request)
    {
        $combined_variations = $product->combinedVariations;
        $requested_variations = $request->variations;
        foreach ($combined_variations as $combined_variation_index => $combined_variation) {
            if ($combined_variation['variation'] == null) {
                if (
                    intval($requested_variations[$combined_variation_index]['price']) > 0 ||
                    intval($requested_variations[$combined_variation_index]['quantity']) > 0 ||
                    intval($requested_variations[$combined_variation_index]['delivery']) > 0
                ) {
                    $options = [];
                    foreach ($combined_variation['options'] as $optin_name => $optione_value) {
                        $options[$optin_name] = $optione_value['value'];
                    }
                    $product->variations()->create([
                        'business_id' => $business->id,
                        'price' => intval($requested_variations[$combined_variation_index]['price']),
                        'quantity' => intval($requested_variations[$combined_variation_index]['quantity']),
                        'delivery' => intval($requested_variations[$combined_variation_index]['delivery']),
                        'options' => $options,
                    ]);
                }
            } else {
                $requested_variations[$combined_variation_index]['status'] = 0;
                $combined_variation['variation']->update($requested_variations[$combined_variation_index]);
            }
        }

        return back();
    }
}
