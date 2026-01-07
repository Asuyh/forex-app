<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForexController;

// Home route – redirect to forex page
Route::get('/', function () {
    return redirect()->route('forex.index');
});

// Forex page route
Route::get('/forex', [ForexController::class, 'index'])
    ->name('forex.index')
    ->middleware('throttle:30,1');

// Debug NRB API route (optional, for testing)
use Illuminate\Support\Facades\Http;
Route::get('/debug-nrb', function () {
    $response = Http::get('https://www.nrb.org.np/api/forex/v1/rates', [
        'from'     => '2026-01-01',
        'to'       => '2026-01-03',
        'page'     => 1,    // required
        'per_page' => 100,  // required (max 100)
    ]);

    return response()->json($response->json());
});
