<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth', 'Auth\AuthenticationController@index')
    ->name('login')
    ->middleware('guest');

Route::post('/auth', 'Auth\AuthenticationController@login')
    ->middleware('guest');

Route::get('/auth/{provider}', 'Auth\AuthenticationController@showProvider')
    ->middleware('guest')
    ->name('login.provider');

Route::get('/auth/{provider}/callback', 'Auth\AuthenticationController@callback')
    ->middleware('guest')
    ->name('login.provider.callback');

Route::middleware('auth')
    ->group(function () {
        Route::view('', 'welcome')
            ->name('home');

        Route::post('/logout', 'Auth\AuthenticationController@logout')
            ->name('logout');

        Route::get('/app/item/types', 'Items\Types\ItemTypeController@index')
            ->name('items.types.index');

        Route::get('/app/item/types/new', 'Items\Types\ItemTypeController@create')
            ->name('items.types.add');

        Route::post('/app/item/types', 'Items\Types\ItemTypeController@store')
            ->name('items.types.store');

        Route::get('/app/view/T{id}', 'Items\Types\ItemTypeController@show')
            ->name('items.types.view');

        Route::get('/app/view/T{id}/edit', 'Items\Types\ItemTypeController@edit')
            ->name('items.types.edit');

        Route::post('/app/view/T{id}/edit', 'Items\Types\ItemTypeController@update')
            ->name('items.types.update');

        Route::get('/app/item/types/{id}/api/fields', 'Items\Types\ItemTypeController@getFields')
            ->name('items.types.fields');

        Route::get('/app/item/type-storage/add', 'Items\Types\TypeStoredAtController@create')
            ->name('items.type-storage.add');

        Route::post('/app/item/type-storage', 'Items\Types\TypeStoredAtController@store')
            ->name('items.type-storage.store');

        Route::delete('/app/item/type-storage/{stored}', 'Items\Types\TypeStoredAtController@destroy')
            ->name('items.type-storage.destroy');

        Route::get('/app/item/fields', 'Items\Fields\FieldController@index')
            ->name('items.fields.index');

        Route::get('/app/item/fields/new', 'Items\Fields\FieldController@create')
            ->name('items.fields.add');

        Route::post('/app/item/fields', 'Items\Fields\FieldController@store')
            ->name('items.fields.store');

        Route::get('/app/view/F{id}', 'Items\Fields\FieldController@show')
            ->name('items.fields.view');

        Route::get('/app/view/F{id}/edit', 'Items\Fields\FieldController@edit')
            ->name('items.fields.edit');

        Route::post('/app/view/F{id}/edit', 'Items\Fields\FieldController@update')
            ->name('items.fields.update');

        Route::get('/app/field-apply/add', 'Items\Fields\FieldAppliesToController@create')
            ->name('items.field-apply.add');

        Route::post('/app/field-apply', 'Items\Fields\FieldAppliesToController@store')
            ->name('items.field-apply.store');

        Route::delete('/app/field-apply/{fat}/destroy', 'Items\Fields\FieldAppliesToController@destroy')
            ->name('items.field-apply.destroy');

        Route::get('/app/items/instances', 'Items\Instances\ItemController@index')
            ->name('items.instances.index');

        Route::get('/app/item/instances/new', 'Items\Instances\ItemController@create')
            ->name('items.instances.add');

        Route::get('/app/item/instances/api/type-locations/{id}', 'Items\Instances\ItemController@getApplicableLocations')
            ->name('item.instances.api.get-type-locations');

        Route::get('/app/item/instances/api/fields/{id}', 'Items\Instances\ItemController@getApplicableFields')
            ->name('item.instances.api.get-type-fields');

        Route::post('/app/item/instances', 'Items\Instances\ItemController@store')
            ->name('items.instances.store');

        Route::get('/app/view/I{id}', 'Items\Instances\ItemController@show')
            ->name('items.instances.view');

        Route::get('/app/view/I{id}/edit', 'Items\Instances\ItemController@edit')
            ->name('items.instances.edit');

        Route::post('/app/view/I{id}/edit', 'Items\Instances\ItemController@update')
            ->name('items.instances.update');

        Route::get('/app/item/checkout/new', 'Items\Instances\ItemCheckoutController@create')
            ->name('items.checkout.add');

        Route::post('/app/item/checkout/new', 'Items\Instances\ItemCheckoutController@store')
            ->name('items.checkout.store');

        Route::get('/app/view/IC{id}', 'Items\Instances\ItemCheckoutController@show')
            ->name('items.checkout.view');

        Route::delete('/app/item/checkout/{checkout}', 'Items\Instances\ItemCheckoutController@destroy')
            ->name('items.checkout.delete');

        Route::get('/app/faults/new', 'Items\Instances\ItemFaultController@create')
            ->name('items.faults.add');

        Route::post('/app/faults/new', 'Items\Instances\ItemFaultController@store')
            ->name('items.faults.store');

        Route::get('/app/view/IF{id}', 'Items\Instances\ItemFaultController@show')
            ->name('items.faults.view');

        Route::get('/app/view/IF{id}/edit', 'Items\Instances\ItemFaultController@edit')
            ->name('items.faults.edit');

        Route::post('/app/view/IF{id}/edit', 'Items\Instances\ItemFaultController@update')
            ->name('items.faults.update');

        Route::get('/app/user/self', 'Auth\UsersController@self')
            ->name('user.profile.self');

        Route::get('/app/user/profile', 'Auth\UsersController@index')
            ->name('user.profile.index');

        Route::get('/app/user/profile/{user}', 'Auth\UsersController@show')
            ->name('user.profile.view');

        Route::get('/app/user/profile/{user}/edit', 'Auth\UsersController@edit')
            ->name('user.profile.edit');

        Route::post('/app/user/profile/{user}/edit', 'Auth\UsersController@update')
            ->name('user.profile.update');

        Route::get('/app/user/groups', 'Auth\GroupController@index')
            ->name('user.groups.index');

        Route::get('/app/users/groups/new', 'Auth\GroupController@create')
            ->name('user.groups.add');

        Route::post('/app/users/groups/new', 'Auth\GroupController@store')
            ->name('user.groups.store');

        Route::get('/app/view/G{id}', 'Auth\GroupController@show')
            ->name('user.groups.view');

        Route::get('/app/view/G{id}/edit', 'Auth\GroupController@edit')
            ->name('user.groups.edit');

        Route::post('/app/view/G{id}/edit', 'Auth\GroupController@update')
            ->name('user.groups.update');

        Route::post('/app/search', 'SearchController')
            ->name('search');

        Route::post('/app/comment', 'Comment\CommentController')
            ->name('comment.store');
    });
