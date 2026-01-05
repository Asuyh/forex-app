<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NrbForexService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.nrb_forex.base_url');
    }

    public function fetchRates(
        string $from,
        string $to,
        int $page = 1,
        int $perPage = 10
    ): array {
        $response = Http::get($this->baseUrl . '/rates', [
            'from'     => $from,
            'to'       => $to,
            'page'     => $page,
            'per_page' => $perPage,
        ]);

        if ($response->failed()) {
            return [
                'error' => true,
                'status' => $response->status(),
                'body' => $response->json(),
            ];
        }

        return $response->json();
    }
}
