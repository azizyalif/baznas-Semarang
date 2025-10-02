import { Chart, PieController, ArcElement, TimeScale, Tooltip, } from 'chart.js';
import { getCssVariable } from '../utils';
import 'chartjs-adapter-moment';

Chart.register(PieController, ArcElement, TimeScale, Tooltip);
const dashboardKecamatan = () => {
    const ctx = document.getElementById('dashboard-kecamatan');
    if (!ctx) return;

    const darkMode = localStorage.getItem('dark-mode') === 'true';

    const tooltipTitleColor = {
        light: '#1F2937',
        dark: '#F3F4F6'
    };

    const tooltipBodyColor = {
        light: '#6B7280',
        dark: '#9CA3AF'
    };

    const tooltipBgColor = {
        light: '#ffffff',
        dark: '#374151'
    };

    const tooltipBorderColor = {
        light: '#E5E7EB',
        dark: '#4B5563'
    };
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            },
            datalabels: {
                color: '#222',
                font: {
                    weight: 'bold',
                    size: 14
                },
                formatter: function (value, context) {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return percentage + '%';
                }
            }
        }
    };
    
        fetch('/json-get-data-by-kecamatan')
            .then(response => response.json())
            .then(data => {
                const kecamatanLabels = data.labels;
                const kecamatanData = data.data;

                // Pastikan Anda sudah mengimpor library Chart.js
                // Di sini Anda bisa menggunakan data untuk membuat grafik
                const ctx = document.getElementById('dashboard-kecamatan');

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: kecamatanLabels,
                        datasets: [{
                            data: kecamatanData,
                            backgroundColor: colors.slice(0, kecamatanLabels.length),
                            borderWidth: 0,
                            borderColor: '#fff',
                            backgroundColor: [
                                getCssVariable('--color-violet-500'),
                                getCssVariable('--color-sky-500'),
                                getCssVariable('--color-violet-800'),
                            ],
                            hoverBackgroundColor: [
                                getCssVariable('--color-violet-600'),
                                getCssVariable('--color-sky-600'),
                                getCssVariable('--color-violet-900'),
                            ],
                        }],

                    },
                    options: {
                        cutout: '80%',
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        layout: {
                            padding: 24,
                        },
                        plugins: {
                            tooltip: {
                                titleColor: darkMode ? tooltipTitleColor.dark : tooltipTitleColor.light,
                                bodyColor: darkMode ? tooltipBodyColor.dark : tooltipBodyColor.light,
                                backgroundColor: darkMode ? tooltipBgColor.dark : tooltipBgColor.light,
                                borderColor: darkMode ? tooltipBorderColor.dark : tooltipBorderColor.light,
                            },
                            htmlLegend: {
                                // ID of the container to put the legend in
                                containerID: 'dashboard-card-kecamatan',
                            },
                        },
                        interaction: {
                            intersect: false,
                            mode: 'nearest',
                        },
                        animation: {
                            duration: 200,
                        },
                        maintainAspectRatio: false,

                    },
                    plugins: [{
                        ChartDataLabels,
                        id: 'htmlLegend',
                        afterUpdate(c, args, options) {
                            const legendContainer = document.getElementById(options.containerID);
                            const ul = legendContainer.querySelector('ul');
                            if (!ul) return;
                            // Remove old legend items
                            while (ul.firstChild) {
                                ul.firstChild.remove();
                            }
                            // Reuse the built-in legendItems generator
                            const items = c.options.plugins.legend.labels.generateLabels(c);
                            items.forEach((item) => {
                                const li = document.createElement('li');
                                li.style.margin = '4px';
                                // Button element
                                const button = document.createElement('button');
                                button.classList.add('btn-xs', 'bg-white', 'dark:bg-gray-700', 'text-gray-500', 'dark:text-gray-400', 'shadow-xs', 'shadow-black/[0.08]', 'rounded-full');
                                button.style.opacity = item.hidden ? '.3' : '';
                                button.onclick = () => {
                                    c.toggleDataVisibility(item.index, !item.index);
                                    c.update();
                                };
                                // Color box
                                const box = document.createElement('span');
                                box.style.display = 'block';
                                box.style.width = '8px';
                                box.style.height = '8px';
                                box.style.backgroundColor = item.fillStyle;
                                box.style.borderRadius = '4px';
                                box.style.marginRight = '4px';
                                box.style.pointerEvents = 'none';
                                // Label
                                const label = document.createElement('span');
                                label.style.display = 'flex';
                                label.style.alignItems = 'center';
                                const labelText = document.createTextNode(item.text);
                                label.appendChild(labelText);
                                li.appendChild(button);
                                button.appendChild(box);
                                button.appendChild(label);
                                ul.appendChild(li);
                            });
                        },
                    }],
                });
            })
            .catch(error => console.error('Error fetching kecamatan data:', error));

    document.addEventListener('darkMode', (e) => {
        const { mode } = e.detail;
        if (mode === 'on') {
            chart.options.plugins.tooltip.titleColor = tooltipTitleColor.dark;
            chart.options.plugins.tooltip.bodyColor = tooltipBodyColor.dark;
            chart.options.plugins.tooltip.backgroundColor = tooltipBgColor.dark;
            chart.options.plugins.tooltip.borderColor = tooltipBorderColor.dark;
        } else {
            chart.options.plugins.tooltip.titleColor = tooltipTitleColor.light;
            chart.options.plugins.tooltip.bodyColor = tooltipBodyColor.light;
            chart.options.plugins.tooltip.backgroundColor = tooltipBgColor.light;
            chart.options.plugins.tooltip.borderColor = tooltipBorderColor.light;
        }
        chart.update('none');
    });
};
export default dashboardKecamatan;