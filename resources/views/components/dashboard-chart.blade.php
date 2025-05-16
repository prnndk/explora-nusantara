@props(['chart_data'])

<div x-data="{ chart: null }" 
     x-init="chart = new Chart($refs.myChart.getContext('2d'), {
        type: 'line',
        data: {
            labels: {{ json_encode($chart_data['labels']) }},
            datasets: [{
                label: 'Export',
                data: {{ json_encode($chart_data['data']) }},
                fill: false,
                tension: 0.15,
                borderColor: 'rgb(35, 147, 145)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Sales Performance'
                }
            }
        }
     });" 
     class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Monthly Export and Import Volume Trend</h2>
    <div class="relative">
        <canvas x-ref="myChart" class="w-full h-full"></canvas>
    </div>
</div>
