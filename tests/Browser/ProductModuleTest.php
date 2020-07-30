<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\NDProduct;
use Sentinel;

class ProductModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheProductsListPage()
    {
        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products')
                    ->waitForText(ucfirst(trans('module_products.controller.word')))
                    ->assertSee(ucfirst(trans('module_products.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.code')))
                    ->assertSee(ucfirst(trans('validation.attributes.category')))
                    ->assertSee(ucfirst(trans('validation.attributes.product_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itLoadsTheProductDetailPage()
    {
        Sentinel::logout();

        $authuser = ObjectsDusk::authenticated();

        $product = NDProduct::find(2);

        $this->browse(function (Browser $browser) use ($product, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products')
                    ->waitForText(ucfirst(trans('module_products.controller.word')))
                    ->assertSee(ucfirst(trans('module_products.controller.word')))

                    ->click('a[href="'.env('APP_URL').'/products/'.$product->slug.'"]')
                    ->assertPathIs('/products/'.$product->slug)
                    ->assertSee($product->id)
                    ->assertSee($product->code)
                    ->assertSee($product->category)
                    ->assertSee($product->product_name)
                    ->assertSee($product->price)

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itTestsTheProductDeleteModal()
    {
        Sentinel::logout();
        
        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products')
                    ->waitForText(ucfirst(trans('module_products.controller.word')))
                    ->assertSee(ucfirst(trans('module_products.controller.word')))

                    ->click('a[onclick="deleteModal(2)"]')
                    ->waitForText(ucfirst(trans('crud.delete.modal.title')))
                    ->assertSee(ucfirst(trans('crud.delete.modal.title')))
                    ->press(ucfirst(trans('crud.delete.modal.delete')))
                    ->waitForText(ucfirst(trans('crud.delete.message.success')))
                    ->assertSee(ucfirst(trans('crud.delete.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        NDProduct::onlyTrashed()->find(2)->restore();
    }
    
    /**
     * @test
     */
    function itLoadsTheProductFormPage()
    {
        Sentinel::logout();
        
        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->assertSee(ucfirst(trans('crud.create.add')))
                    ->assertPresent('#code')
                    ->assertPresent('#category')
                    ->assertPresent('#type')
                    ->assertPresent('#product_name')
                    ->assertPresent('#supplier')
                    ->assertPresent('#brand')
                    ->assertPresent('#price')
                    ->assertPresent('#quantity')

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itTestsTheCreateProductMethod()
    {
        Sentinel::logout();
        
        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->assertSee(ucfirst(trans('crud.create.add')))
                    ->type('code', 'CARL9876543')
                    ->type('category', 'Dulcería')
                    ->type('type', 'Chicle')
                    ->type('product_name', 'Bubaloo')
                    ->type('supplier', 'Ricolino')
                    ->type('brand', 'Ricolino')
                    ->type('price', 37.5)
                    ->type('quantity', 7)
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.create.message.success')))
                    ->assertSee(ucfirst(trans('crud.create.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $product = NDProduct::where('code', 'CARL9876543')->first();
        NDProduct::destroy($product->id);
    }
    
    /**
     * @test
     */
    function itLoadsTheEditProductFormPage()
    {
        Sentinel::logout();
        
        $authuser = ObjectsDusk::authenticated();

        $product = NDProduct::find(2);

        $this->browse(function (Browser $browser) use ($product, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products')
                    ->waitForText(ucfirst(trans('module_products.controller.word')))
                    ->assertSee(ucfirst(trans('module_products.controller.word')))

                    ->click('a[href="'.env('APP_URL').'/products/'.$product->id.'/edit"]')
                    ->assertPathIs('/products/'.$product->id.'/edit')
                    ->waitForText(ucfirst(trans('crud.sidebar.edit')))
                    ->assertSee(ucfirst(trans('crud.sidebar.edit')))
                    ->assertInputValue('product_name', $product->product_name)

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        $product->save();

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itTestsTheUpdateProductMethod()
    {
        Sentinel::logout();
        
        $authuser = ObjectsDusk::authenticated();

        $product = NDProduct::find(2);

        $this->browse(function (Browser $browser) use ($product, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/products')
                    ->waitForText(ucfirst(trans('module_products.controller.word')))
                    ->assertSee(ucfirst(trans('module_products.controller.word')))

                    ->visit('/products/'.$product->id.'/edit')
                    ->clear('product_name')
                    ->type('product_name', 'Edited')
                    ->type('income', 23)
                    ->press(ucfirst(trans('crud.update.update')))
                    ->waitForText(ucfirst(trans('crud.update.message.success')))
                    ->assertSee(ucfirst(trans('crud.update.message.success')))
                    ->assertInputValue('product_name', 'Edited')

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        $product->save();

        ObjectsDusk::deleteUser($authuser['email']);
    }
}
