<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanDeleteProvidersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_providers()
    {        
        // Given
        $user = User::factory()->create();

        $provider = Provider::factory()->create();

        // When
        $this->actingAs($user)->deleteJson(route('providers.destroy', $provider));

        // Then
        $this->assertDatabaseMissing('providers', $provider->toArray());
    }
}
