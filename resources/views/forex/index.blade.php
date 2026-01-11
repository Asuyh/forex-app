<!DOCTYPE html>
<html>
<head>
    <title>Nepal Rastra Bank - Forex Rates</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .notice { margin: 10px 0; padding: 10px; background-color: #fffae6; border: 1px solid #ffd42a; }
    </style>
</head>
<body>

<h2>Today's Forex Rates ({{ $today }})</h2>

@if(count($todayForex) === 0)
    <p><strong>No forex data published yet for today.</strong></p>
@else
<table>
    <tr>
        <th>Currency</th>
        <th>Unit</th>
        <th>Buying (NPR)</th>
        <th>Selling (NPR)</th>
    </tr>
    @foreach($todayForex as $rate)
        <tr>
            <td>{{ $rate['currency']['name'] }} ({{ $rate['currency']['iso3'] }})</td>
            <td>{{ $rate['currency']['unit'] }}</td>
            <td>{{ number_format($rate['buy'], 2) }}</td>
            <td>{{ number_format($rate['sell'], 2) }}</td>
        </tr>
    @endforeach
</table>

<hr>

<h2>Currency Converter (Based on Today’s Rates)</h2>

<form id="converterForm">
    <input type="number" id="amount" placeholder="Amount" step="any" required>

    <select id="fromCurrency">
        <option value="NPR">NPR</option>
        @foreach($todayForex as $rate)
            <option value="{{ $rate['currency']['iso3'] }}">
                {{ $rate['currency']['iso3'] }}
            </option>
        @endforeach
    </select>

    <select id="toCurrency">
        <option value="NPR">NPR</option>
        @foreach($todayForex as $rate)
            <option value="{{ $rate['currency']['iso3'] }}">
                {{ $rate['currency']['iso3'] }}
            </option>
        @endforeach
    </select>

    <button type="button" id="convertBtn">Convert</button>
</form>

<p id="conversionResult"></p>
@endif

<hr>

<h1>Historical Forex Rates</h1>

<form method="get" action="{{ route('forex.index') }}">
    From: <input type="date" name="from" value="{{ $from }}">
    To: <input type="date" name="to" value="{{ $to }}">
    <button type="submit">Fetch Rates</button>
</form>

@if($to !== $latestAvailableDate)
    <div class="notice" id="latestNotice">
        Latest available forex data is for <strong>{{ $latestAvailableDate }}</strong>.
    </div>
@endif

<div id="forexTables">
@foreach($forexData as $day)
    <h2>Forex Rates — {{ $day['date'] }}</h2>
    <table>
        <tr>
            <th>Currency</th>
            <th>Unit</th>
            <th>Buying (NPR)</th>
            <th>Selling (NPR)</th>
        </tr>
        @foreach($day['rates'] as $rate)
            <tr>
                <td>{{ $rate['currency']['name'] }} ({{ $rate['currency']['iso3'] }})</td>
                <td>{{ $rate['currency']['unit'] }}</td>
                <td>{{ number_format($rate['buy'], 2) }}</td>
                <td>{{ number_format($rate['sell'], 2) }}</td>
            </tr>
        @endforeach
    </table>
@endforeach
</div>

{{-- Pass forex data safely to JS --}}
<script>
    window.todayForexRates = @json($todayForex);
</script>

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
