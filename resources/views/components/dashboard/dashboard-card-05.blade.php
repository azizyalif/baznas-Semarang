<div class="flex flex-col col-span-full sm:col-span-6 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold text-gray-800 dark:text-gray-100">Permohonan Berdasarkan Kecamatan</h2>
    </header>
    <div id="dashboard-card-04-legend" class="px-5 py-3">
        <ul class="flex flex-wrap gap-x-4"></ul>
    </div>
    <div class="grow">
        <canvas id="kecamatanChart" height="220"></canvas>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/json-get-data-by-kecamatan')
        .then(response => response.json())
        .then(data => {
            const kecamatanLabels = data.kecamatan.labels;
            const kecamatanData = data.kecamatan.data;
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                '#FF9F40', '#C9CBCF', '#4BC0C0', '#FF6384', '#36A2EB'
            ];

            const ctx = document.getElementById('kecamatanChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: kecamatanLabels,
                    datasets: [{
                        data: kecamatanData,
                        backgroundColor: colors.slice(0, kecamatanLabels.length),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        datalabels: {
                            color: '#222',
                            font: { weight: 'bold', size: 14 },
                            formatter: function(value, context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return percentage + '%';
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        })
        .catch(error => console.error('Error fetching kecamatan data:', error));
});
</script>