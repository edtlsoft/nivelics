<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanCreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_products()
    {   $this->withoutExceptionHandling();
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create();

        $product = [
            'name' => 'Product name',
            'price' => '10000.00',
            'quantity' => '150',
            'provider_id' => $provider->id,
        ];

        // When
        $this->actingAs($user)->postJson(route('products.store'), $product);

        // Then
        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function a_product_requires_a_name()
    {
        // Given
        $user = User::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('products.store'), []);

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_product_name_requires_a_minimum_length()
    {
        // Given
        $user = User::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('products.store'), [
            'name' => 'one',
        ]);
        
        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_product_name_must_be_unique()
    {
        // Given
        $user = User::factory()->create();

        $product = Product::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('products.store'), [
            'name' => $product->name
        ]);

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }
}
