@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="grid grid-cols-4 gap-4">
    <a href="/payroll?page=validate" class="relative bg-white rounded-r-md border-l-[6px] border-blue-500 p-4 shadow-md grid grid-cols-2 hover:bg-blue-50">
        {{-- <span id="notificationBadge" class="absolute top-0 -right-1 bg-red-600 text-white rounded-full px-[6px] text-sm hidden">1</span> --}}
        <div class="flex items-end">
            <img class="size-12" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-payroll-human-resources-flaticons-lineal-color-flat-icons.png" alt="external-payroll-human-resources-flaticons-lineal-color-flat-icons"/>
        </div>
        <div class="grid items-center justify-end text-right">
            <span class="text-sm text-gray-500">Total of Employee</span>
            <span class="text-3xl font-semibold text-gray-800">11</span>
        </div>
    </a>
    <a href="/timesheet?page=review" class="relative bg-white rounded-r-md border-l-[6px] border-violet-500 p-4 shadow-md grid grid-cols-2 hover:bg-violet-50">
        {{-- <span id="notificationBadge" class="absolute top-0 -right-1 bg-red-600 text-white rounded-full px-[6px] text-sm hidden">1</span> --}}
        <div class="flex items-end">
            <img class="size-12" src="https://img.icons8.com/color/48/property-time.png" alt="property-time"/>
        </div>
        <div class="grid items-center justify-end text-right">
            <span class="text-sm text-gray-500">Total of Seminars</span>
            <span class="text-3xl font-semibold text-gray-800">200</span>
        </div>
    </a>
    <a href="" class="relative bg-white rounded-r-md border-l-[6px] border-red-500 p-4 shadow-md grid grid-cols-2 hover:bg-red-50">
        {{-- <span id="notificationBadge" class="absolute top-0 -right-1 bg-red-600 text-white rounded-full px-[6px] text-sm hidden">1</span> --}}
        <div class="flex items-end">
            <img class="size-12" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-overtime-human-resources-flaticons-lineal-color-flat-icons.png" alt="external-overtime-human-resources-flaticons-lineal-color-flat-icons"/>
        </div>
        <div class="grid items-center justify-end text-right">
            <span class="text-sm text-gray-500">Total of Learnings</span>
            <span class="text-3xl font-semibold text-gray-800">200</span>
        </div>
    </a>
    <a href="/reimbursement?page=request" class="relative bg-white rounded-r-md border-l-[6px] border-green-500 p-4 shadow-md grid grid-cols-2 hover:bg-green-50">
        {{-- <span id="notificationBadge" class="absolute top-0 -right-1 bg-red-600 text-white rounded-full px-[6px] text-sm hidden">1</span> --}}
        <div class="flex items-end">
            <img class="size-12" src="https://img.icons8.com/bubbles/100/refund.png" alt="refund"/>
        </div>
        <div class="grid items-center justify-end text-right">
            <span class="text-sm text-gray-500">Total Employee Task</span>
            <span class="text-3xl font-semibold text-gray-800">200</span>
        </div>
    </a>
</div>

<div class="mt-4 grid grid-cols-8    gap-4">
    <!-- Right column with charts -->
    <div class="col-span-8">
        <div class="grid grid-cols-12 gap-4">
            <!-- Succession Planning Chart -->
            <div class="col-span-6 shadow-md bg-white rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Succession Planning Growth</h3>
                <div id="successionChart" style="height: 300px;"></div>
            </div>

            <!-- Learning System Chart -->
            <div class="col-span-6 shadow-md bg-white rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Learning System Participation</h3>
                <div id="learningChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>
    <script>
        // Succession Planning Chart
        document.addEventListener('DOMContentLoaded', function() {
          const successionOptions = {
            series: [{
              name: 'Ready Now',
              data: [12, 14, 15, 18, 20, 22, 25, 28]
            }, {
              name: 'Ready Soon (1-2 Years)',
              data: [18, 20, 21, 24, 26, 28, 30, 35]
            }, {
              name: 'Future Potential',
              data: [25, 26, 28, 30, 32, 34, 38, 45]
            }],
            chart: {
              type: 'bar',
              height: 300,
              stacked: true,
              toolbar: {
                show: false
              }
            },
            plotOptions: {
              bar: {
                horizontal: false,
                columnWidth: '55%',
                borderRadius: 2
              },
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              show: true,
              width: 2,
              colors: ['transparent']
            },
            xaxis: {
              categories: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            },
            yaxis: {
              title: {
                text: 'Employees'
              }
            },
            fill: {
              opacity: 1
            },
            tooltip: {
              y: {
                formatter: function (val) {
                  return val + " employees"
                }
              }
            },
            colors: ['#4f46e5', '#8b5cf6', '#c4b5fd']
          };

          const successionChart = new ApexCharts(document.querySelector("#successionChart"), successionOptions);
          successionChart.render();

          // Learning System Chart
          const learningOptions = {
            series: [{
              name: 'Course Enrollments',
              data: [420, 450, 480, 520, 580, 620, 710, 780]
            }, {
              name: 'Completed Courses',
              data: [350, 380, 410, 440, 490, 540, 600, 680]
            }, {
              name: 'Certification Rate',
              data: [75, 76, 78, 80, 82, 84, 85, 87]
            }],
            chart: {
              height: 300,
              type: 'line',
              toolbar: {
                show: false
              }
            },
            stroke: {
              width: [4, 4, 4],
              curve: 'smooth'
            },
            xaxis: {
              categories: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            },
            yaxis: [
              {
                title: {
                  text: 'Enrollments',
                },
                min: 300,
              },
              {
                opposite: true,
                title: {
                  text: 'Completion Rate (%)'
                },
                min: 70,
                max: 100
              }
            ],
            tooltip: {
              intersect: false,
              shared: true
            },
            colors: ['#10b981', '#047857', '#f59e0b']
          };

          const learningChart = new ApexCharts(document.querySelector("#learningChart"), learningOptions);
          learningChart.render();
        });
      </script>

@endsection
