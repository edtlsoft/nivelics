<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanDeleteProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_products()
    {        
        // Given
        $user = User::factory()->create();

        $product = Product::factory()->create();

        // When
        $this->actingAs($user)->deleteJson(route('products.destroy', $product));

        // Then
        $this->assertDatabaseMissing('products', $product->toArray());
    }
}
