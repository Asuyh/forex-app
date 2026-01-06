<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NrbForexService;
use Carbon\Carbon;

class ForexController extends Controller
{
    public function index(Request $request, NrbForexService $service)
    {
        // Default to today's date (NRB behavior)
        $today = Carbon::today()->format('Y-m-d');

        $from = $request->get('from', $today);
        $to   = $request->get('to', $today);

        $data = $service->fetchRates($from, $to);

        return view('forex.index', compact('from', 'to', 'data'));
    }
}
