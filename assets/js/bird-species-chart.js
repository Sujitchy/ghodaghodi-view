document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('ghodaghodi-bird-chart');
    if (!canvas || typeof window.Chart === 'undefined') return;

    var ctx = canvas.getContext('2d');

    var gradient = ctx.createLinearGradient(0, 0, 0, canvas.parentNode.offsetHeight || 400);
    gradient.addColorStop(0, 'rgba(5, 150, 105, 0.28)');
    gradient.addColorStop(1, 'rgba(5, 150, 105, 0.02)');

    var months = ['बैशाख', 'जेठ', 'असार', 'साउन', 'भदौ', 'असोज', 'कात्तिक', 'मङ्सिर', 'पुस', 'माघ', 'फागुन', 'चैत'];

    var wetland = [12, 13, 17, 18, 16, 15, 17, 20, 21, 20, 15, 12];
    var forest = [6, 6, 8, 9, 8, 7, 9, 10, 11, 10, 8, 6];

    var wetlandTotal = wetland.reduce(function (sum, value) { return sum + value; }, 0);
    var forestTotal = forest.reduce(function (sum, value) { return sum + value; }, 0);
    var grandTotal = wetlandTotal + forestTotal;

    var fontFamily = "'Mukta', 'Noto Sans', sans-serif";

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'सिमसार तथा जलपक्षी',
                    data: wetland,
                    borderColor: '#059669',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#059669',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#059669',
                    pointHoverBorderColor: '#ffffff',
                },
                {
                    label: 'जङ्गल तथा घाँसे मैदानका पक्षी',
                    data: forest,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    borderDash: [6, 4],
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#f59e0b',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#f59e0b',
                    pointHoverBorderColor: '#ffffff',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            layout: {
                padding: {
                    top: 8,
                    right: 8,
                    bottom: 4,
                    left: 4,
                },
            },
            animation: {
                duration: 1600,
                easing: 'easeOutQuart',
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        boxWidth: 8,
                        boxHeight: 8,
                        color: '#374151',
                        padding: 14,
                        font: {
                            family: fontFamily,
                            size: 13,
                            weight: '600',
                        },
                    },
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(2, 44, 34, 0.96)',
                    titleColor: '#fbbf24',
                    bodyColor: '#ffffff',
                    borderColor: 'rgba(255, 255, 255, 0.12)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12,
                    caretSize: 6,
                    titleFont: {
                        family: fontFamily,
                        size: 14,
                        weight: '700',
                    },
                    bodyFont: {
                        family: fontFamily,
                        size: 13,
                    },
                    footerFont: {
                        family: fontFamily,
                        size: 12,
                        weight: '600',
                    },
                    usePointStyle: true,
                    callbacks: {
                        title: function (context) {
                            return 'महिना: ' + context[0].label;
                        },
                        label: function (context) {
                            return ' ' + context.dataset.label + ': ' + context.parsed.y + ' प्रजाति';
                        },
                        footer: function () {
                            return 'जम्मा: ' + grandTotal.toLocaleString('ne-NP') + ' प्रजाति (२९०+)';
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    border: {
                        color: 'rgba(2, 44, 34, 0.2)',
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: fontFamily,
                            size: 12,
                        },
                        autoSkip: true,
                        maxTicksLimit: 12,
                        maxRotation: 0,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(2, 44, 34, 0.06)',
                    },
                    border: {
                        display: false,
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: fontFamily,
                            size: 12,
                        },
                        precision: 0,
                        callback: function (value) {
                            return value + ' प्रजाति';
                        },
                    },
                },
            },
        },
    });
});