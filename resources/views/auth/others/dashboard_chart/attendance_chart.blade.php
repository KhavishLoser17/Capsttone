<div class="p-4">
    <div class="flex flex-grow items-center justify-between p-2 border-b border-gray-200 mb-2">
        <h2 class="text-sm uppercase font-semibold text-gray-600">Daily Attendance</h2>
        <a href="#" class="text-blue-500 hover:text-blue-700 text-sm hover:underline">See All &gt;</a>
    </div>
    <canvas id="attendanceRateChartElement"></canvas>
</div>
{{--
<script>
document.addEventListener('DOMContentLoaded', function () {
    const attendanceRateChartElement = document.getElementById('attendanceRateChartElement');
    if (attendanceRateChartElement) {
        const donut = attendanceRateChartElement.getContext('2d');
        new Chart(donut, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent', 'Late', 'On-Leave'],
            datasets: [{
            label: 'Attendance',
            data: [90, 4, 6, 5],
            backgroundColor: [
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                enabled: true
            }
            }
        }
        });
    }
});

</script> --}}
