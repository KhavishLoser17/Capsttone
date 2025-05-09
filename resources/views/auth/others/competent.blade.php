@extends('layouts.hr3-admin')
@section('title', 'Competency Employee Results')

@section('content')
<style>
    .hover-primary:hover {
    color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.1);
    transition: all 0.2s ease;
}

.bg-light-primary {
    background-color: rgba(13, 110, 253, 0.05);
}

.bg-soft-primary {
    background-color: rgba(250, 250, 250, 0.15);
}
</style>
<div class="container-fluid">
  <div class="bg-white border-bottom py-3 mb-4">
    <div class="container mx-auto px-4">
            <nav class="flex items-center py-4 space-x-6">
                <a href="{{route('competent')}}" class="flex items-center px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>
                    <span>Learning Management</span>
                </a>
                <a href="{{route('reflection')}}" class="flex items-center px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium">
                    <i class="fas fa-users-cog mr-2"></i>
                    <span>Training Management</span>
                </a>
            </nav>
        </div>
</div>

<!-- Page Header -->
<div class="container mb-5">
    <div class="d-flex align-items-center bg-light-primary p-4 rounded-3 border-start border-4 border-primary">
        <div class="bg-soft-primary p-3 rounded-circle me-4">
            <i class="fas fa-award fa-lg text-primary"></i>
        </div>
        <div>
            <h1 class="h2 mb-1 fw-bold text-gray-800">Employee Competency Analytics</h1>
            <p class="mb-0 text-muted">Track and analyze employee skill development and training progress</p>
        </div>
    </div>
</div>

    <!-- Summary Cards -->
    <div class="bg-white grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Assessments Card -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-yellow-950 rounded-xl shadow-lg p-5 transition-transform hover:scale-[1.02]">
          <div class="flex justify-between items-center">
            <div>
              <div class="text-xs uppercase font-bold tracking-wider mb-1 opacity-90">Total Assessments</div>
              <div class="text-3xl font-bold">{{ $passedCount + $failedCount }}</div>
            </div>
            <div class="bg-yellow-200/50 p-3 rounded-lg">
              <i class="fas fa-clipboard-list text-yellow-950 text-2xl"></i>
            </div>
          </div>
        </div>

        <!-- Passed Assessments Card -->
        <div class="bg-gradient-to-br from-green-400 to-green-600 text-green-950 rounded-xl shadow-lg p-5 transition-transform hover:scale-[1.02]">
          <div class="flex justify-between items-center">
            <div>
              <div class="text-xs uppercase font-bold tracking-wider mb-1 opacity-90">Passed Assessments</div>
              <div class="text-3xl font-bold">{{ $passedCount }}</div>
            </div>
            <div class="bg-green-200/50 p-3 rounded-lg">
              <i class="fas fa-check-circle text-green-950 text-2xl"></i>
            </div>
          </div>
        </div>

        <!-- Failed Assessments Card -->
        <div class="bg-gradient-to-br from-red-400 to-pink-500 text-red-950 rounded-xl shadow-lg p-5 transition-transform hover:scale-[1.02]">
          <div class="flex justify-between items-center">
            <div>
              <div class="text-xs uppercase font-bold tracking-wider mb-1 opacity-90">Failed Assessments</div>
              <div class="text-3xl font-bold">{{ $failedCount }}</div>
            </div>
            <div class="bg-red-200/50 p-3 rounded-lg">
              <i class="fas fa-times-circle text-red-950 text-2xl"></i>
            </div>
          </div>
        </div>

        <!-- Average Score Card -->
        <div class="bg-gradient-to-br from-sky-400 to-indigo-500 text-indigo-950 rounded-xl shadow-lg p-5 transition-transform hover:scale-[1.02]">
          <div class="flex justify-between items-center mb-3">
            <div>
              <div class="text-xs uppercase font-bold tracking-wider mb-1 opacity-90">Average Score</div>
              <div class="text-3xl font-bold">{{ round($examResults->avg('percentage'), 1) }}%</div>
            </div>
            <div class="bg-indigo-200/50 p-3 rounded-lg">
              <i class="fas fa-chart-line text-indigo-950 text-2xl"></i>
            </div>
          </div>
          <div class="w-full bg-indigo-100 rounded-full h-2">
            <div class="bg-indigo-800 h-2 rounded-full" style="width: {{ round($examResults->avg('percentage'), 1) }}%;"></div>
          </div>
        </div>
      </div>
    <!-- Tabs Navigation -->


    <!-- Main Content Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="tab-content" id="competencyTabContent">
            <!-- Assessment Results Tab -->
            <div class="tab-pane fade show active p-6" id="results" role="tabpanel" aria-labelledby="results-tab">
                <div class="flex items-center p-4 mb-6 rounded-lg bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500">
                    <div class="mr-4 bg-blue-100 text-blue-600 rounded-full p-2">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-800">Assessment Overview</h3>
                        <p class="text-blue-600">Showing {{ $examResults->count() }} competency assessments. Use the table filters to narrow down results.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm shadow-md rounded-lg">
                        <thead class="bg-gradient-to-r from-cyan-600 to-teal-700 text-black text-sm uppercase tracking-wide">
                          <tr>
                            <th class="px-6 py-4 text-left"><i class="fas fa-file-alt mr-2"></i>Exam Title</th>
                            <th class="px-6 py-4 text-center"><i class="fas fa-tasks mr-2"></i>Total Attempts</th>
                            <th class="px-6 py-4 text-center"><i class="fas fa-check mr-2"></i>Passed</th>
                            <th class="px-6 py-4 text-center"><i class="fas fa-times mr-2"></i>Failed</th>
                            <th class="px-6 py-4 text-center"><i class="fas fa-percentage mr-2"></i>Pass Rate</th>
                            <th class="px-6 py-4 text-center"><i class="fas fa-chart-line mr-2"></i>Avg Score</th>
                            <th class="px-6 py-4"><i class="fas fa-exclamation-triangle mr-2"></i>Competency Gap</th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($examStats as $exam)
                          @php
                            $passRate = $exam->attempt_count > 0 ? round(($exam->passed_count / $exam->attempt_count) * 100, 1) : 0;
                            $gapPercentage = 100 - $exam->avg_score;
                            $gapInfo = [
                              'color' => $gapPercentage < 15 ? 'bg-blue-500' : ($gapPercentage < 30 ? 'bg-yellow-400' : 'bg-red-500'),
                              'label' => $gapPercentage < 15 ? 'Low' : ($gapPercentage < 30 ? 'Moderate' : 'High'),
                              'icon' => $gapPercentage < 15 ? 'info-circle' : ($gapPercentage < 30 ? 'exclamation-circle' : 'exclamation-triangle'),
                              'badge' => $gapPercentage < 15 ? 'bg-blue-100 text-blue-800' : ($gapPercentage < 30 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'),
                            ];
                          @endphp
                          <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold flex items-center space-x-3">
                              <div class="w-10 h-10 bg-blue-300 text-black flex items-center justify-center rounded-full">
                                <i class="fas fa-file-alt"></i>
                              </div>
                              <span class="capitalize">{{ $exam->title }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                              <span class="inline-block px-3 py-1 bg-indigo-300 text-black rounded-full text-xs font-semibold">{{ $exam->attempt_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                              <span class="inline-block px-3 py-1 bg-green-300 text-black rounded-full text-xs font-semibold">{{ $exam->passed_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                              <span class="inline-block px-3 py-1 bg-red-300 text-black rounded-full text-xs font-semibold">{{ $exam->attempt_count - $exam->passed_count }}</span>
                            </td>
                            <td class="px-6 py-4">
                              <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden shadow-inner">
                                <div class="h-full text-xs text-black text-center font-bold leading-6 {{ $passRate >= 80 ? 'bg-green-600' : ($passRate >= 60 ? 'bg-yellow-500' : 'bg-red-600') }}" style="width: {{ $passRate }}%;">
                                  {{ $passRate }}%
                                </div>
                              </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                              <span class="inline-block px-4 py-2 rounded-full text-xs font-semibold
                                {{ $exam->avg_score >= 80 ? 'bg-green-100 text-green-800' : ($exam->avg_score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $exam->avg_score }}%
                              </span>
                            </td>
                            <td class="px-6 py-4">
                              <div class="flex items-center space-x-2">
                                <div class="w-full bg-gray-200 rounded-full h-4 shadow-inner overflow-hidden">
                                  <div class="h-full {{ $gapInfo['color'] }} text-xs font-bold text-black text-center leading-4" style="width: {{ $gapPercentage }}%;">
                                    {{ $gapPercentage }}%
                                  </div>
                                </div>
                                <span class="text-xs font-semibold inline-flex items-center px-2.5 py-1.5 rounded-full {{ $gapInfo['badge'] }}">
                                  <i class="fas fa-{{ $gapInfo['icon'] }} mr-1"></i>{{ $gapInfo['label'] }}
                                </span>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div class="tab-pane fade p-6" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="flex items-center p-4 mb-6 rounded-lg bg-gradient-to-r from-green-50 to-teal-50 border-l-4 border-green-500">
                    <div class="mr-4 bg-green-100 text-green-600 rounded-full p-2">
                        <i class="fas fa-chart-bar text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800">Visual Analytics</h3>
                        <p class="text-green-600">Interactive charts showing competency assessment performance metrics.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Competency Distribution Chart -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-black px-6 py-4">
                            <h3 class="font-bold flex items-center"><i class="fas fa-chart-pie mr-2"></i>Pass/Fail Distribution</h3>
                        </div>
                        <div class="p-6">
                            <div class="chart-container h-72 w-full relative">
                                <canvas id="competencyPieChart" class="w-full h-full block"></canvas>
                            </div>
                            <div class="flex justify-center space-x-6 pt-4 border-t mt-4">
                                <div class="flex items-center">
                                    <span class="inline-block w-4 h-4 rounded-full bg-green-500 mr-2"></span>
                                    <span class="text-sm font-medium">Passed ({{ $passedCount }})</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="inline-block w-4 h-4 rounded-full bg-red-500 mr-2"></span>
                                    <span class="text-sm font-medium">Failed ({{ $failedCount }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Average Score by Exam -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-6 py-4">
                            <h3 class="font-bold flex items-center"><i class="fas fa-chart-bar mr-2"></i>Exam Performance</h3>
                        </div>
                        <div class="p-6">
                            <div class="chart-container h-72 w-full relative">
                                <canvas id="examBarChart" class="w-full h-full block"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Analysis Tab -->
            <div class="tab-pane fade p-6" id="employee-analysis" role="tabpanel" aria-labelledby="employee-analysis-tab">
                <div class="flex items-center p-4 mb-6 rounded-lg bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500">
                    <div class="mr-4 bg-yellow-100 text-yellow-600 rounded-full p-2">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-yellow-800">Employee Analysis</h3>
                        <p class="text-yellow-600">Individual performance metrics and competency levels across all assessments.</p>
                    </div>
                </div>

                <!-- Filter and Export Buttons -->
                <div class="flex flex-wrap gap-3 mb-4">
                    <div class="dropdown inline-block relative">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>
                        <ul class="dropdown-menu hidden absolute z-10 bg-white shadow-lg rounded-lg mt-1 py-2 w-48">
                            <li><a href="#" class="filter-option block px-4 py-2 hover:bg-gray-100 text-gray-800" data-filter="all">All Employees</a></li>
                            <li><a href="#" class="filter-option block px-4 py-2 hover:bg-gray-100 text-gray-800" data-filter="passed">Passed Exams</a></li>
                            <li><a href="#" class="filter-option block px-4 py-2 hover:bg-gray-100 text-gray-800" data-filter="not-taken">Not Taken Exams</a></li>
                            <li><a href="#" class="filter-option block px-4 py-2 hover:bg-gray-100 text-gray-800" data-filter="expert">Expert Level</a></li>
                            <li><a href="#" class="filter-option block px-4 py-2 hover:bg-gray-100 text-gray-800" data-filter="novice">Needs Training</a></li>
                        </ul>
                    </div>

                    <button id="export-excel" class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>
                        <span>Generate Excel Report</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table id="employee-table" class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-yellow-500 to-amber-600 text-black">
                          <tr>
                            <th class="px-6 py-4 text-left font-semibold"><i class="fas fa-user mr-2"></i>Employee ID</th>
                            <th class="px-6 py-4 text-left font-semibold"><i class="fas fa-user mr-2"></i>Employee Name</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-clipboard-list mr-2"></i>Exams Taken</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-check mr-2"></i>Exams Passed</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-percentage mr-2"></i>Pass Rate</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-chart-line mr-2"></i>Avg Score</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-award mr-2"></i>Competency Level</th>
                            <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-chart-bar mr-2"></i>Trend</th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($userStats as $user)
                            @php
                              $passRate = $user['exams_taken'] > 0 ? round(($user['exams_passed'] / $user['exams_taken']) * 100, 1) : 0;
                              $trendValue = rand(-10, 10);

                              // Add data attributes for filtering
                              $dataAttributes = '';
                              if ($user['exams_taken'] == 0) {
                                  $dataAttributes .= ' data-not-taken="true"';
                              }
                              if ($user['exams_passed'] > 0) {
                                  $dataAttributes .= ' data-passed="true"';
                              }
                              if ($user['avg_score'] >= 90) {
                                  $dataAttributes .= ' data-level="expert"';
                              } elseif ($user['avg_score'] < 60) {
                                  $dataAttributes .= ' data-level="novice"';
                              }
                            @endphp
                            <tr class="hover:bg-gray-50" {!! $dataAttributes !!}>
                              <td class="px-6 py-4 text-center font-medium text-gray-700">{{ $user['employeeId'] }}</td>
                              <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-amber-400 to-yellow-500 text-black flex items-center justify-center font-semibold">
                                  {{ substr($user['first_name'], 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user['first_name'] }}</span>
                              </td>
                              <td class="px-6 py-4 text-center">
                                <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full font-medium">{{ $user['exams_taken'] }}</span>
                              </td>
                              <td class="px-6 py-4 text-center">
                                <span class="text-sm bg-green-100 text-green-800 px-3 py-1.5 rounded-full font-medium">{{ $user['exams_passed'] }}</span>
                              </td>
                              <td class="px-6 py-4">
                                <div class="relative w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                                  <div class="absolute top-0 left-0 h-full {{ $passRate >= 80 ? 'bg-green-500' : ($passRate >= 60 ? 'bg-yellow-500' : 'bg-red-500') }} text-center text-xs font-bold text-black" style="width: {{ $passRate }}%">
                                    {{ $passRate }}%
                                  </div>
                                </div>
                              </td>
                              <td class="px-6 py-4 text-center">
                                <span class="text-sm {{ $user['avg_score'] >= 80 ? 'bg-green-200 text-green-800' : ($user['avg_score'] >= 60 ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }} px-3 py-1.5 rounded-full font-medium">
                                  {{ $user['avg_score'] }}%
                                </span>
                              </td>
                              <td class="px-6 py-4 text-center">
                                @if($user['avg_score'] >= 90)
                                  <span class="text-sm bg-emerald-100 text-emerald-800 px-3 py-1.5 rounded-full font-semibold inline-flex items-center"><i class="fas fa-award mr-1.5 text-amber-500"></i>Expert</span>
                                @elseif($user['avg_score'] >= 80)
                                  <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full font-semibold inline-flex items-center"><i class="fas fa-star mr-1.5 text-blue-500"></i>Advanced</span>
                                @elseif($user['avg_score'] >= 70)
                                  <span class="text-sm bg-cyan-100 text-cyan-800 px-3 py-1.5 rounded-full font-semibold inline-flex items-center"><i class="fas fa-check-circle mr-1.5 text-cyan-500"></i>Proficient</span>
                                @elseif($user['avg_score'] >= 60)
                                  <span class="text-sm bg-yellow-100 text-yellow-800 px-3 py-1.5 rounded-full font-semibold inline-flex items-center"><i class="fas fa-exclamation-circle mr-1.5 text-yellow-500"></i>Basic</span>
                                @else
                                  <span class="text-sm bg-red-100 text-red-800 px-3 py-1.5 rounded-full font-semibold inline-flex items-center"><i class="fas fa-times-circle mr-1.5 text-red-500"></i>Novice</span>
                                @endif
                              </td>
                              <td class="px-6 py-4 text-center">
                                @if($trendValue > 3)
                                  <span class="text-green-600 font-medium inline-flex items-center"><i class="fas fa-arrow-up mr-1.5"></i>{{ $trendValue }}%</span>
                                @elseif($trendValue < -3)
                                  <span class="text-red-600 font-medium inline-flex items-center"><i class="fas fa-arrow-down mr-1.5"></i>{{ abs($trendValue) }}%</span>
                                @else
                                  <span class="text-gray-500 font-medium inline-flex items-center"><i class="fas fa-equals mr-1.5"></i>Stable</span>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Set custom color palette for all charts
    Chart.defaults.color = '#4B5563'; // Text color
    Chart.defaults.font.family = "'Nunito', 'Segoe UI', sans-serif";

    // --------- PASS/FAIL DISTRIBUTION PIE CHART ---------
    const competencyPieCtx = document.getElementById('competencyPieChart').getContext('2d');

    // Get passed and failed counts from PHP variables
    const passedCount = parseInt("{{ $passedCount }}");
    const failedCount = parseInt("{{ $failedCount }}");

    const competencyPieChart = new Chart(competencyPieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Passed', 'Failed'],
            datasets: [{
                data: [passedCount, failedCount],
                backgroundColor: [
                    'rgba(52, 211, 153, 0.8)', // Green for passed
                    'rgba(239, 68, 68, 0.8)'   // Red for failed
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(220, 38, 38)'
                ],
                borderWidth: 2,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false // Hide legend as we have custom legend below
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14
                    },
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const total = passedCount + failedCount;
                            const percentage = Math.round((context.raw / total) * 100);
                            return `${context.raw} ${context.label} (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#ffffff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value, ctx) => {
                        const total = passedCount + failedCount;
                        if (total === 0) return '';
                        return Math.round((value / total) * 100) + '%';
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });

    // --------- EXAM PERFORMANCE BAR CHART ---------
    const examBarCtx = document.getElementById('examBarChart').getContext('2d');

    // Get data from PHP controller
    let examNames = @json($examNames);
    // Capitalize each exam name
    examNames = examNames.map(name => {
        return name.split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    });
    const examScores = @json($examScores);

    const examBarChart = new Chart(examBarCtx, {
        type: 'bar',
        data: {
            labels: examNames,
            datasets: [{
                label: 'Average Score (%)',
                data: examScores,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(139, 92, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(236, 72, 153, 0.7)',
                    'rgba(14, 165, 233, 0.7)',
                    'rgba(168, 85, 247, 0.7)'
                ],
                borderColor: [
                    'rgb(37, 99, 235)',
                    'rgb(124, 58, 237)',
                    'rgb(5, 150, 105)',
                    'rgb(217, 119, 6)',
                    'rgb(219, 39, 119)',
                    'rgb(2, 132, 199)',
                    'rgb(139, 92, 246)'
                ],
                borderWidth: 2,
                borderRadius: 6,
                hoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',  // Horizontal bar chart
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(17, 24, 39, 0.9)',
                    titleFont: {
                        size: 16,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 14
                    },
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return `Average Score: ${context.raw}%`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            weight: 'bold'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Score (%)',
                        color: '#4B5563',
                        font: {
                            weight: 'bold',
                            size: 14
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });

    // Enhance the UI by adding colored backgrounds to the chart containers
    document.querySelectorAll('.bg-white').forEach((element, index) => {
        if (index === 0) {
            // Pass/Fail pie chart container
            element.classList.remove('bg-white');
            element.classList.add('bg-gradient-to-br', 'from-purple-50', 'to-indigo-50');
        } else if (index === 1) {
            // Exam performance bar chart container
            element.classList.remove('bg-white');
            element.classList.add('bg-gradient-to-br', 'from-blue-50', 'to-cyan-50');
        }
    });

    // Add responsive hover effects to chart containers
    document.querySelectorAll('.chart-container').forEach(container => {
        container.parentElement.addEventListener('mouseenter', function() {
            this.classList.add('transform', 'scale-[1.01]', 'transition-all', 'duration-300');
            this.style.boxShadow = '0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1)';
        });

        container.parentElement.addEventListener('mouseleave', function() {
            this.classList.remove('transform', 'scale-[1.01]');
            this.style.boxShadow = '';
        });
    });

    // Function to add more statistics below the charts


    // Call the function to add statistics
    addStatistics();
});
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown functionality
            document.querySelector('.dropdown button').addEventListener('click', function() {
                document.querySelector('.dropdown-menu').classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown')) {
                    document.querySelector('.dropdown-menu').classList.add('hidden');
                }
            });

            // Filter functionality
            document.querySelectorAll('.filter-option').forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filter = this.getAttribute('data-filter');
                    const rows = document.querySelectorAll('#employee-table tbody tr');

                    rows.forEach(row => {
                        switch(filter) {
                            case 'all':
                                row.classList.remove('hidden');
                                break;
                            case 'passed':
                                row.classList.toggle('hidden', !row.hasAttribute('data-passed'));
                                break;
                            case 'not-taken':
                                row.classList.toggle('hidden', !row.hasAttribute('data-not-taken'));
                                break;
                            case 'expert':
                                row.classList.toggle('hidden', row.getAttribute('data-level') !== 'expert');
                                break;
                            case 'novice':
                                row.classList.toggle('hidden', row.getAttribute('data-level') !== 'novice');
                                break;
                        }
                    });

                    // Update button text to show current filter
                    const filterText = this.textContent;
                    document.querySelector('.dropdown button span').textContent = filterText;
                    document.querySelector('.dropdown-menu').classList.add('hidden');
                });
            });

            // Excel Export functionality using SheetJS
            document.getElementById('export-excel').addEventListener('click', function() {
                // Create workbook
                const wb = XLSX.utils.book_new();

                // Extract data from table
                const table = document.getElementById('employee-table');

                // Get headers
                const headers = [];
                table.querySelectorAll('thead th').forEach(th => {
                    // Remove the icon from the header text
                    const headerText = th.textContent.replace(/^\s*[\r\n]/gm, '').trim();
                    headers.push(headerText);
                });

                // Get visible rows only (respect filtering)
                const rows = [];
                table.querySelectorAll('tbody tr:not(.hidden)').forEach(tr => {
                    const row = [];
                    tr.querySelectorAll('td').forEach((td, index) => {
                        // Handle different column types appropriately
                        if (index === 1) { // Name column with avatar
                            row.push(td.textContent.trim());
                        } else if (index === 4) { // Pass Rate column with progress bar
                            const percentage = td.querySelector('div div').textContent.trim();
                            row.push(percentage);
                        } else {
                            row.push(td.textContent.trim());
                        }
                    });
                    rows.push(row);
                });

                // Create worksheet with headers and data
                const wsData = [headers, ...rows];
                const ws = XLSX.utils.aoa_to_sheet(wsData);

                // Add worksheet to workbook
                XLSX.utils.book_append_sheet(wb, ws, "Employee Analysis");

                // Generate filename with date
                const date = new Date().toISOString().slice(0,10);
                const filename = `Employee_Analysis_Report_${date}.xlsx`;

                // Export to file
                XLSX.writeFile(wb, filename);
            });

            // Add some basic styling for dropdown
            const style = document.createElement('style');
            style.textContent = `
                .dropdown-menu {
                    transition: all 0.2s ease-in-out;
                }
                .dropdown-menu.hidden {
                    opacity: 0;
                    transform: translateY(-10px);
                    pointer-events: none;
                }
            `;
            document.head.appendChild(style);
        });
        </script>
@endsection
