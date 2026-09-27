(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById('ghodaghodi-bird-chart');
        if (!canvas || typeof window.Chart === 'undefined') return;

        var ctx = canvas.getContext('2d');
        var wrapper = canvas.parentNode;
        var legendEl = document.getElementById('ghodaghodi-chart-legend');
        var tooltipEl = document.getElementById('ghodaghodi-chart-tooltip');

        var fontFamily = "'Mukta', 'Noto Sans', sans-serif";

        var gradient = ctx.createLinearGradient(0, 0, 0, wrapper.offsetHeight || 400);
        gradient.addColorStop(0, 'rgba(5, 150, 105, 0.28)');
        gradient.addColorStop(1, 'rgba(5, 150, 105, 0.02)');

        var months = [
            'बैशाख (Baishakh)',
            'जेठ (Jeth)',
            'असार (Asar)',
            'साउन (Sawan)',
            'भदौ (Bhadau)',
            'असोज (Asoj)',
            'कात्तिक (Kartik)',
            'मङ्सिर (Mangsir)',
            'पुस (Poush)',
            'माघ (Magh)',
            'फागुन (Falgun)',
            'चैत (Chait)',
        ];

        var seriesMeta = [
            {
                ne: 'सिमसार तथा जलपक्षी',
                en: 'Wetland & Waterbirds',
                color: '#059669',
                data: [12, 13, 17, 18, 16, 15, 17, 20, 21, 20, 15, 12],
            },
            {
                ne: 'जङ्गल तथा घाँसे मैदानका पक्षी',
                en: 'Forest & Grassland Birds',
                color: '#f59e0b',
                data: [6, 6, 8, 9, 8, 7, 9, 10, 11, 10, 8, 6],
            },
        ];

        var grandTotal = seriesMeta.reduce(function (sum, series) {
            return sum + series.data.reduce(function (a, b) { return a + b; }, 0);
        }, 0);

        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: seriesMeta.map(function (series, index) {
                    return {
                        label: series.en,
                        data: series.data,
                        borderColor: series.color,
                        backgroundColor: index === 0 ? gradient : 'rgba(245, 158, 11, 0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        borderDash: index === 0 ? undefined : [6, 4],
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: series.color,
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: series.color,
                        pointHoverBorderColor: '#ffffff',
                    };
                }),
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
                        display: false,
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        position: 'nearest',
                        external: function (context) {
                            if (!tooltipEl) return;

                            var tooltip = context.tooltip;

                            if (tooltip.opacity === 0) {
                                tooltipEl.style.opacity = '0';
                                return;
                            }

                            var title = tooltip.title.length ? tooltip.title[0] : '';

                            var rows = tooltip.dataPoints.map(function (point) {
                                var meta = seriesMeta[point.datasetIndex];
                                if (!meta) return '';
                                return (
                                    '<div class="gh-tip-row">' +
                                    '<span class="gh-tip-dot" style="background:' + meta.color + '"></span>' +
                                    '<span lang="ne">' + meta.ne + ': <strong>' + point.parsed.y + '</strong></span>' +
                                    ' <span>/ ' + meta.en + ': ' + point.parsed.y + ' species</span>' +
                                    '</div>'
                                );
                            }).join('');

                            tooltipEl.innerHTML =
                                '<div class="gh-tip-title" lang="ne">' + title + '</div>' +
                                rows +
                                '<div class="gh-tip-total" lang="ne">जम्मा: ' + grandTotal + ' प्रजाति (२९०+)</div>' +
                                '<div class="gh-tip-total-en">/ Total: ' + grandTotal + ' species (290+)</div>';

                            tooltipEl.style.opacity = '1';

                            var tooltipWidth = tooltipEl.offsetWidth;
                            var tooltipHeight = tooltipEl.offsetHeight;
                            var wrapperWidth = wrapper.clientWidth;

                            var left = Math.min(Math.max(tooltip.caretX, tooltipWidth / 2 + 6), Math.max(tooltipWidth / 2 + 6, wrapperWidth - tooltipWidth / 2 - 6));
                            var top = tooltip.caretY - tooltipHeight - 14;

                            if (top < 4) {
                                top = tooltip.caretY + 14;
                            }

                            tooltipEl.style.left = left + 'px';
                            tooltipEl.style.top = top + 'px';
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
                                size: 11,
                            },
                            autoSkip: true,
                            maxRotation: 0,
                            minRotation: 0,
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
                                return value + ' species';
                            },
                        },
                    },
                },
            },
        });

        if (legendEl) {
            function buildLegend() {
                legendEl.innerHTML = '';
                seriesMeta.forEach(function (meta, index) {
                    var item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'ghodaghodi-legend-item';
                    item.setAttribute('aria-pressed', String(true));
                    item.innerHTML =
                        '<span class="ghodaghodi-legend-dot" style="background:' + meta.color + '"></span>' +
                        '<span lang="ne">' + meta.ne + '</span>' +
                        '<span class="ghodaghodi-legend-sep" role="presentation">/</span>' +
                        '<span>' + meta.en + '</span>';

                    item.addEventListener('click', function () {
                        var visible = chart.isDatasetVisible(index);
                        chart.setDatasetVisibility(index, !visible);
                        chart.update();
                        item.classList.toggle('ghodaghodi-legend-muted', visible);
                        item.setAttribute('aria-pressed', String(!visible));
                        item.setAttribute('aria-label', (!visible ? 'Show ' : 'Hide ') + meta.en);
                    });

                    legendEl.appendChild(item);
                });
            }

            buildLegend();
        }
    });
})();