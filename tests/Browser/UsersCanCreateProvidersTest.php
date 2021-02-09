<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanCreateProvidersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_authenticated_can_create_providers()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/providers')
                ->waitFor('@form-create-provider')
                ->click('@form-create-provider')
                ->whenAvailable('#modal-providers-form', function ($modal) {
                    $modal->assertSee('REGISTRAR PROVEEDOR')
                        ->type('@provider-name', 'provider_number_one')
                        ->press('@btn-manage-providers')
                        ;
                })
                ->waitForText('El proveedor se registro correctamente.')
                ->assertSee('El proveedor se registro correctamente.')
                ->waitForText('provider_number_one')
                ->assertSee('provider_number_one')
                ;
        });
    }
}
