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

Route::view('', 'welcome')
    ->name('home');

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

        Route::get('/app/item/types/{id}/fields', 'Items\Types\ItemTypeController@getFields')
            ->name('items.types.fields');

        Route::get('/app/item/type-storage/add', 'Items\Types\TypeStoredAtController@create')
            ->name('items.type-storage.add');

        Route::post('/app/item/type-storage', 'Items\Types\TypeStoredAtController@store')
            ->name('items.type-storage.store');

        Route::get('/app/item/fields', 'Items\Fields\FieldController@index')
            ->name('items.fields.index');

        Route::get('/app/view/F{id}', 'Items\Fields\FieldController@show')
            ->name('items.fields.view');

        Route::get('/app/user/self', function() {
            return 'foo bar';
        })
            ->name('profile');
    });
