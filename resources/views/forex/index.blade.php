<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>NRB Forex Rates</title>
</head>

<body class="bg-gray-100">
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold text-blue-700 mb-6">
        Nepal Rastra Bank - Foreign Exchange Rates
    </h1>

    <form method="GET" class="flex flex-wrap gap-4 items-end mb-8 bg-white p-4 rounded shadow-sm border border-blue-100">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
            <input
                type="date"
                name="from"
                value="{{ $from }}"
                class="border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
            <input
                type="date"
                name="to"
                value="{{ $to }}"
                class="border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <div>
            <button
                type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
            >
                Fetch Rates
            </button>
        </div>
    </form>

    <!-- Error Statement print -->
    @if(!empty($data) && $data['error'])
        <div class="p-4 mb-6 border border-red-300 bg-red-50 text-red-700 rounded">
            Failed to fetch forex data from NRB.
        </div>
    @endif

    <!-- forex data no Published Yet -->
    @if(!empty($data) && !$data['error'] && empty($data['body']['data']['payload']))
        <div class="p-4 mb-6 border border-yellow-300 bg-yellow-50 text-yellow-800 rounded">
            Forex rates for the selected date have not been published yet.
        </div>
    @endif

    <!-- Forex Tables -->
    @if(!empty($data) && !$data['error'] && !empty($data['body']['data']['payload']))

        @foreach($data['body']['data']['payload'] as $day)

            <!-- Date Header -->
            <div class="mt-10 mb-3 border-b border-blue-200 pb-1">
                <h3 class="text-lg font-semibold text-blue-700">
                    Forex Rates — {{ $day['date'] }}
                </h3>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded shadow-sm">
                <table class="min-w-full border border-blue-200 text-sm">
                    <thead class="bg-blue-50 text-blue-800">
                        <tr>
                            <th class="border border-blue-200 px-4 py-2 text-left">
                                Currency
                            </th>
                            <th class="border border-blue-200 px-4 py-2 text-center">
                                Unit
                            </th>
                            <th class="border border-blue-200 px-4 py-2 text-right">
                                Buying (NPR)
                            </th>
                            <th class="border border-blue-200 px-4 py-2 text-right">
                                Selling (NPR)
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($day['rates'] as $rate)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="border border-blue-200 px-4 py-2">
                                    <div class="font-medium text-gray-800">
                                        {{ $rate['currency']['name'] }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $rate['currency']['iso3'] }}
                                    </div>
                                </td>

                                <td class="border border-blue-200 px-4 py-2 text-center">
                                    {{ $rate['currency']['unit'] }}
                                </td>

                                <td class="border border-blue-200 px-4 py-2 text-right">
                                    {{ number_format($rate['buy'], 2) }}
                                </td>

                                <td class="border border-blue-200 px-4 py-2 text-right">
                                    {{ number_format($rate['sell'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endforeach

    @endif

</div>
</body>
</html>
