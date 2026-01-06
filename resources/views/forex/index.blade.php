<h2 class="text-xl font-bold mb-4">NRB Forex Rates</h2>

<form method="GET" class="mb-6">
    <label>
        From:
        <input type="date" name="from" value="{{ $from ?? '' }}">
    </label>

    <label class="ml-4">
        To:
        <input type="date" name="to" value="{{ $to ?? '' }}">
    </label>

    <button class="ml-4 px-4 py-2 bg-blue-600 text-white">
        Fetch
    </button>
</form>

@if(!empty($data))

    @if($data['error'])
        <pre class="text-red-600">
            {{ print_r($data['body'], true) }}
        </pre>
    @else
        <pre class="bg-gray-100 p-4">
            {{ print_r($data['body'], true) }}
        </pre>
    @endif

@endif
