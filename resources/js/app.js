import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {

    if (typeof window.todayForexRates === 'undefined') return;

    const ratesMap = {};

    // Build rate map (normalized to 1 unit)
    window.todayForexRates.forEach(rate => {
        const iso = rate.currency.iso3;
        const unit = parseFloat(rate.currency.unit);
        const buy = parseFloat(rate.buy);

        ratesMap[iso] = buy / unit;
    });

    // NPR base
    ratesMap['NPR'] = 1;

    document.getElementById('convertBtn')?.addEventListener('click', function () {
        const amount = parseFloat(document.getElementById('amount').value);
        const from = document.getElementById('fromCurrency').value;
        const to = document.getElementById('toCurrency').value;

        if (!amount || !ratesMap[from] || !ratesMap[to]) {
            document.getElementById('conversionResult').innerText = 'Invalid input.';
            return;
        }

        const amountInNPR = amount * ratesMap[from];
        const converted = amountInNPR / ratesMap[to];

        document.getElementById('conversionResult').innerText =
            `${amount} ${from} = ${converted.toFixed(4)} ${to}`;
    });
});
