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

        Route::get('/app/user/self', 'Auth\UsersController@self')
            ->name('user.profile.self');

        Route::get('/app/user/profile/{user}', 'Auth\UsersController@show')
            ->name('user.profile.view');

        Route::get('/app/user/profile/{user}/edit', 'Auth\UsersController@edit')
            ->name('user.profile.edit');
    });
