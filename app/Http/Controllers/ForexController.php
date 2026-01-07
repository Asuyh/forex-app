<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ForexController extends Controller
{
    public function index(Request $request)
    {
        // Default dates
        $from = $request->get('from') ?? now()->subDays(7)->format('Y-m-d');
        $to   = $request->get('to') ?? now()->format('Y-m-d');

        // API only publishes completed day data, adjust "to"
        $today = now()->format('Y-m-d');
        $latestAvailableDate = $to;

        if ($to >= $today) {
            $latestAvailableDate = now()->subDay()->format('Y-m-d'); // last published date
            $to = $latestAvailableDate;
        }

        // Call NRB API
        $response = Http::get('https://www.nrb.org.np/api/forex/v1/rates', [
            'from'     => $from,
            'to'       => $to,
            'page'     => 1,
            'per_page' => 100,
        ]);

        $json = $response->json();

        // Extract payload safely
        $forexData = $json['data']['payload'] ?? [];

        return view('forex.index', [
            'from' => $from,
            'to' => $to,
            'forexData' => $forexData,
            'latestAvailableDate' => $latestAvailableDate
        ]);
    }
}
