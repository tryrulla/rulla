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

Route::get('/', function () {
    return view('welcome');
})
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
        Route::get('/app/item/types', 'Items\Types\ItemTypeController@index')
            ->name('items.types.index');

        Route::get('/app/view/T{id}', 'Items\Types\ItemTypeController@show')
            ->name('items.types.view');

        Route::get('/app/item/type-storage/add', 'Items\Types\TypeStoredAtController@create')
            ->name('items.type-storage.add');

        Route::post('/app/item/type-storage', 'Items\Types\TypeStoredAtController@store')
            ->name('items.type-storage.store');
    });
