<div>
    <div x-data="{ chart: null }" x-init="chart = new Chart(document.getElementById('myChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Dataset 1',
                    data: [10, 5, 30, 40, 20, 60, 70],
                    fill: false,
                    tension: 0.1,
                    borderColor: 'rgba(255, 99, 132, 1)',
                },
                {
                    label: 'Dataset 2',
                    data: [15, 25, 35, 45, 55, 65, 75],
                    fill: false,
                    tension: 0.5,
                    borderColor: 'rgba(54, 162, 235, 1)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Sales Performance'
                }
            }
        },
    });" class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Monthly Export and Import Volume Trend</h2>
        <div class="relative h-96">
            <canvas id="myChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>
