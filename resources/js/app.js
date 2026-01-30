import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {

    if (!window.todayForexRates || window.todayForexRates.length === 0) {
        console.warn('No forex rates available for conversion.');
        return;
    }

    const ratesMap = { NPR: 1 };

    window.todayForexRates.forEach(rate => {
        const iso = rate.currency.iso3;
        const unit = Number(rate.currency.unit);
        const buy = Number(rate.buy);

        ratesMap[iso] = buy / unit;
    });

    const convertBtn = document.getElementById('convertBtn');

    if (!convertBtn) {
        console.error('Convert button not found.');
        return;
    }

    convertBtn.addEventListener('click', function () {
        const amount = Number(document.getElementById('amount').value);
        const from = document.getElementById('fromCurrency').value;
        const to = document.getElementById('toCurrency').value;
        const resultEl = document.getElementById('conversionResult');

        if (!amount || !ratesMap[from] || !ratesMap[to]) {
            resultEl.innerText = 'Please enter a valid amount and currencies.';
            return;
        }

        const amountInNPR = amount * ratesMap[from];
        const converted = amountInNPR / ratesMap[to];

        resultEl.innerText =
            `${amount} ${from} = ${converted.toFixed(4)} ${to}`;
    });

});
