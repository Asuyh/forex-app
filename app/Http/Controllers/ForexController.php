<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForexController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');

        $todayResponse = Http::get('https://www.nrb.org.np/api/forex/v1/rates', [
            'from'     => $today,
            'to'       => $today,
            'page'     => 1,
            'per_page' => 100,
        ]);

        $todayForex = $todayResponse->json()['data']['payload'][0]['rates'] ?? [];


        // Default dates
        $from = $request->get('from') ?? now()->subDays(7)->format('Y-m-d');
        $to   = $request->get('to') ?? now()->format('Y-m-d');

        // NRB publishes only completed-day data
        $latestAvailableDate = $to;

        if ($to >= $today) {
            $latestAvailableDate = now()->subDay()->format('Y-m-d');
            $to = $latestAvailableDate;
        }

        $response = Http::get('https://www.nrb.org.np/api/forex/v1/rates', [
            'from'     => $from,
            'to'       => $to,
            'page'     => 1,
            'per_page' => 100,
        ]);

        $forexData = $response->json()['data']['payload'] ?? [];

        return view('forex.index', [
    'from' => $from,
    'to' => $to,
    'forexData' => $forexData,
    'latestAvailableDate' => $latestAvailableDate,
    'todayForex' => $todayForex,
    'today' => $today,
    'showHistory' => $request->has('from') && $request->has('to')
]);

    }
}
