<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Provider;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanCreateProductsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_authenticated_can_create_products()
    {
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        $this->browse(function (Browser $browser) use ($user, $provider) {
            $browser->loginAs($user)
                ->visit('/products')
                ->waitFor('@form-create-product')
                ->click('@form-create-product')
                ->whenAvailable('#modal-products-form', function ($modal) use ($provider) {
                    $modal->assertSee('REGISTRAR PRODUCTO')
                        ->type('@product-name', 'product_number_one')
                        ->type('@product-price', '15000.50')
                        ->type('@product-quantity', '145')
                        ->select('@product-provider', $provider->id)
                        ->press('@btn-manage-products')
                        ;
                })
                ->waitForText('El producto se registro correctamente.')
                ->assertSee('El producto se registro correctamente.')
                ->waitForText('product_number_one')
                ->assertSee('product_number_one')
                ;
        });
    }
}
