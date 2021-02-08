<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanCreateProvidersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_providers()
    {
        $this->withoutExceptionHandling();
        
        // Given
        $user = User::factory()->create();

        $provider = ['name' => 'Provider name'];

        // When
        $response = $this->actingAs($user)->postJson(route('providers.store'), $provider);

        // Then
        $response->assertStatus(201);

        $this->assertDatabaseHas('providers', $provider);
    }

    /** @test */
    public function a_provider_requires_a_name()
    {
        // Given
        $user = User::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('providers.store'), []);

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_requires_a_minimum_length()
    {
        // Given
        $user = User::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('providers.store'), [
            'name' => 'one',
        ]);
        
        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }

    /** @test */
    public function a_provider_name_must_be_unique()
    {
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create();

        // When
        $response = $this->actingAs($user)->postJson(route('providers.store'), [
            'name' => $provider->name
        ]);

        // Then
        $response->assertStatus(422);

        $response->assertJsonStructure(['message', 'errors' => ['name']]);
    }
}
