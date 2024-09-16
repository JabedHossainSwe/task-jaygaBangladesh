<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        // Create a category
        $category = Category::factory()->create();

        // Create attributes
        $attributes = Attribute::factory()->count(2)->create();

        // Prepare request data
        $data = [
            'name' => 'Smartphone',
            'category_id' => $category->id,
            'attributes' => [
                ['id' => $attributes[0]->id, 'value' => 'Black'],
                ['id' => $attributes[1]->id, 'value' => '64GB'],
            ],
        ];

        // Send a POST request to the API
        $response = $this->postJson('/api/products', $data);

        // Assert that the response status is 201 Created
        $response->assertStatus(Response::HTTP_CREATED);

        // Assert that the product is in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Smartphone',
            'category_id' => $category->id,
        ]);

        // Assert that the attributes are attached to the product
        $product = Product::where('name', 'Smartphone')->first();
        $this->assertTrue($product->attributes()->wherePivot('value', 'Black')->exists());
        $this->assertTrue($product->attributes()->wherePivot('value', '64GB')->exists());
    }
}
