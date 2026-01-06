<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NrbForexService;

class ForexController extends Controller
{
    public function index(Request $request, NrbForexService $service)
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        $data = [];

        if ($from && $to) {
            $data = $service->fetchRates($from, $to);
        }

        return view('forex.index', compact('from', 'to', 'data'));
    }
}
