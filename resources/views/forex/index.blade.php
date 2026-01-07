<!DOCTYPE html>
<html>
<head>
    <title>Nepal Rastra Bank - Forex Rates</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .notice { margin: 10px 0; padding: 10px; background-color: #fffae6; border: 1px solid #ffd42a; }
    </style>
</head>
<body>

<h1>Nepal Rastra Bank - Foreign Exchange Rates</h1>

<form method="get" action="{{ route('forex.index') }}">
    From: <input type="date" name="from" value="{{ $from }}">
    To: <input type="date" name="to" value="{{ $to }}">
    <button type="submit">Fetch Rates</button>
</form>

@if($to !== $latestAvailableDate)
    <div class="notice" id="latestNotice">
        Note: The latest available forex data is for <strong>{{ $latestAvailableDate }}</strong>. Data for your selected 'To' date is not yet published.
    </div>
@endif

<div id="forexTables">
    @if(count($forexData) === 0)
        <p>No forex data available for the selected range.</p>
    @endif

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

<script>
    // Auto-refresh every 5 minutes (300000 ms)
    setInterval(function(){
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            // Parse HTML
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, 'text/html');

            // Update forex tables
            let newTables = doc.getElementById('forexTables').innerHTML;
            document.getElementById('forexTables').innerHTML = newTables;

            // Update notice if any
            let newNotice = doc.getElementById('latestNotice');
            if(newNotice){
                document.getElementById('latestNotice').innerHTML = newNotice.innerHTML;
            }

        })
        .catch(err => console.log('Error fetching updated forex data:', err));
    }, 300000); // every 5 minutes
</script>

</body>
</html>
