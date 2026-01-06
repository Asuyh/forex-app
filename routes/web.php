<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ForexController;
Route::get('/forex',[ForexController::class, 'index'])
->middleware('throttle:30,1');



Route::get('/', function () {
    return view('forex.index', [
        'from' => request('from'),
        'to'   => request('to'),
        'data' => []
    ]);
});

Route::get('/', [ForexController::class, 'index']);
