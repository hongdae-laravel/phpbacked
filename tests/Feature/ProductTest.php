<?php

namespace Tests\Feature;

use App\Product;
use App\User;
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
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $product = factory(Product::class)->make();

        $data = [
            'url' => $product->url,
            'name' => $product->name
        ];

        $this->postJson('/api/products', $data);

        $this->assertDatabaseHas('products', $data);
    }

    public function testProductsNeedsActivation()
    {
        $product = factory(Product::class)->make();

        $data = [
            'url' => $product->url,
            'name' => $product->name
        ];

        $this->post('/api/products', $data);

        $newProduct = $data;
        $newProduct['is_active'] = false;

        $this->assertDatabaseHas('products', $newProduct);
    }
}
