<?php

namespace App\Http\Controllers;

use App\Events\ProductsCreated;
use App\Http\Requests\StoreProductsRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function store(StoreProductsRequest $request)
    {
        $product = Product::create([
            'url' => $request->input('url'),
            'name' => $request->input('name')
        ]);

        event(new ProductsCreated($product));

        return $product;
    }

    public function index(Request $request, Product $product)
    {
        return $product->latest()->paginate(12);
    }
}
