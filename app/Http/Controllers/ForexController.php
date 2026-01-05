<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servieces\NrbForexServiece;

class ForexController extends Controller
{
    public function index(Request $request, NrbForexService $serviece)
    {
        $request-> validate([
            'form' => 'nullable | date_format:y-m-d',
            'to' => 'nullable | date_format:y-m-d',
        ]);

        $from = $request->input('from', now()->subDays(7)->format(y-m-d));
        $to = $request->input('to',now()->format(y-m-d));

        $data = $serviece->fetchRates($from, $to);
        return view('forex.index', compact('data', 'from', 'to'));
    }
}
