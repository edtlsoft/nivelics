<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use Tests\DuskTestCase;
use App\Models\Provider;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanUpdateProductsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_user_authenticated_can_update_products()
    {
        $user = User::factory()->create();

        $provider = Provider::factory()->create(['name' => 'Provider one']);

        $product = Product::factory()->create([
            'name' => 'Product one',
            'price' => '5200.50',
            'quantity' => '120',
        ]);

        $this->browse(function (Browser $browser) use ($user, $provider) {
            $browser->loginAs($user)
                ->visit('/products')
                ->waitFor('@form-update-product')
                ->click('@form-update-product')
                ->whenAvailable('#modal-products-form', function ($modal) use ($provider) {
                    $modal->assertSee('ACTUALIZAR PRODUCTO')
                        ->type('@product-name', 'product_updated')
                        ->type('@product-price', '10000.50')
                        ->type('@product-quantity', '100')
                        ->select('@product-provider', $provider->id)
                        ->press('@btn-manage-products')
                        ;
                })
                ->waitForText('El producto se actualizo correctamente.')
                ->assertSee('El producto se actualizo correctamente.')
                ->waitForText('product_updated')
                ->assertSee('product_updated')
                ->assertSee('10000.5')
                ->assertSee('100')
                ->assertSee('Provider one')
                ;
        });
    }
}
