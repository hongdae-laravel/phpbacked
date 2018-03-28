<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function store()
    {
        Product::create([
            'url' => request('url'),
            'name' => request('name')
        ]);
    }
}
