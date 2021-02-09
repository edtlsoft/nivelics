<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Provider;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanUpdateProvidersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_authenticated_can_update_providers()
    {
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/providers')
                ->waitFor('@form-update-provider')
                ->click('@form-update-provider')
                ->whenAvailable('#modal-providers-form', function ($modal) {
                    $modal->assertSee('ACTUALIZAR PROVEEDOR')
                        ->type('@provider-name', 'provider_updated')
                        ->press('@btn-manage-providers')
                        ;
                })
                ->waitForText('El proveedor se actualizo correctamente.')
                ->assertSee('El proveedor se actualizo correctamente.')
                ->waitForText('provider_updated')
                ->assertSee('provider_updated')
                ;
        });
    }
}
