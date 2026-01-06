<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NrbForexService
{
    public function fetchRates(string $from, string $to, int $page = 1, int $perPage = 100): array
    {
        $response = Http::get(config('forex.nrb_base_url') . '/rates', [
            'from' => $from,
            'to' => $to,
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if ($response->failed()) {
            return [
                'error' => true,
                'body' => $response->json(),
            ];
        }

        return [
            'error' => false,
            'body' => $response->json(),
        ];
    }
}
