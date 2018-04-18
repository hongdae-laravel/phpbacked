<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function store(StoreProductsRequest $request)
    {
        return Product::create([
            'url' => $request->input('url'),
            'name' => $request->input('name')
        ]);
    }

    public function index(Request $request, Product $product)
    {
        return $product->latest()->paginate(12);
    }
}
