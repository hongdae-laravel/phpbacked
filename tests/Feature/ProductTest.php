<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAnyoneCanSubmitUrl()
    {
        $product = factory(Product::class)->make();

        $data = [
            'url' => $product->url,
            'name' => $product->name
        ];

        $this->post('/products', $data);

        $this->assertDatabaseHas('products', $data);
    }

    public function testProductsNeedsActivation()
    {
        $product = factory(Product::class)->make();

        $data = [
            'url' => $product->url,
            'name' => $product->name
        ];

        $this->post('/products', $data);

        $newProduct = $data;
        $newProduct['is_active'] = false;

        $this->assertDatabaseHas('products', $newProduct);
    }
}
