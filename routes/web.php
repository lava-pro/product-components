<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubstanceController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Frontend -------------

// Find products by substance sets
Route::get('/products/find', function (Request $request) {
    $request->merge([
        'substances' => [1, 5, 7, 9, 11],
    ]);
    return App::call('App\Http\Controllers\FrontendController@findProducts');
});

// CRUD Substances -----------

// Show
Route::get('/substances/{id?}', [SubstanceController::class, 'show']);

// Create
Route::get('/substance/create', function (Request $request) {
    $request->merge([
        'name'   => 'Substance 1',
        'status' => 1,
    ]);
    return App::call('App\Http\Controllers\SubstanceController@create');
});

// Update
Route::get('/substance/update/{id?}', function (Request $request) {
    $request->merge([
        'name'   => 'Substance 1 Hidden',
        'status' => 0,
    ]);
    return App::call('App\Http\Controllers\SubstanceController@update', ['id' => 1]);
});

// Delete
Route::get('/substance/delete/{id?}', function () {
    return App::call('App\Http\Controllers\SubstanceController@delete', ['id' => 1]);
});

// CRUD Products -----------

// Show
Route::get('/products/{id?}', [ProductController::class, 'show']);

// Create
Route::get('/product/create', function (Request $request) {
    $request->merge([
        'name'       => 'Product 5S',
        'substances' => [1, 5, 7, 9, 11],
    ]);
    return App::call('App\Http\Controllers\ProductController@create');
});

// Update
Route::get('/product/update/{id?}', function (Request $request) {
    $request->merge([
        'name'       => 'Product 5S Edited',
        'substances' => [1, 5, 7, 12, 13],
    ]);
    return App::call('App\Http\Controllers\ProductController@update', ['id' => 1]);
});

// Delete
Route::get('/product/delete/{id?}', function () {
    return App::call('App\Http\Controllers\ProductController@delete', ['id' => 1]);
});