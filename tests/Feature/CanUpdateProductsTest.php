<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanUpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_update_products()
    {        
        $this->withoutExceptionHandling();
        // Given
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'name' => 'Product one',
            'price' => '5200.50',
            'quantity' => '120',
        ]);

        // When
        $this->actingAs($user)->putJson(
            route('products.update', $product), 
            [
                'name' => 'Product updated',
                'price' => '6000.50',
                'quantity' => '150',
            ]
        );

        // Then
        $this->assertDatabaseHas('products', [
            'name' => 'Product updated',
            'price' => '6000.50',
            'quantity' => '150',
        ]);
    }

    /** @test */
    public function a_provider_requires_a_name()
    {
        // Given
        $user = User::factory()->create();

        $provider = Product::factory()->create(['name' => 'Product one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('products.update', $provider), 
            []
        );

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_requires_a_minimum_length()
    {
        // Given
        $user = User::factory()->create();

        $provider = Product::factory()->create(['name' => 'Product one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('products.update', $provider), 
            ['name' => 'one']
        );
        
        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_must_be_unique()
    {
        // Given
        $user = User::factory()->create();

        $provider = Product::factory()->create(['name' => 'Product one']);

        // When
        $response = $this->actingAs($user)->putJson(
            route('products.update', $provider), 
            ['name' => $provider->name]
        );

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }
}
