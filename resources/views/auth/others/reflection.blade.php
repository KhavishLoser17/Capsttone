@extends('layouts.hr3-admin')

@section('title')
    Employee Reflection Evaluations
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Top Navigation -->
    <div class="bg-white border-b shadow-sm">
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

    <div class="container mx-auto px-4 py-8">
        <!-- Header and Title -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Training Reflection Evaluations</h1>
            <p class="text-gray-600 mt-1">Review and evaluate employee training reflections</p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button id="pending-tab" onclick="switchTab('pending')" class="py-4 px-6 font-medium text-sm inline-flex items-center border-b-2 border-blue-600 text-blue-600">
                        <i class="fas fa-hourglass-half mr-2"></i>
                        Pending Evaluations
                    </button>
                    <button id="completed-tab" onclick="switchTab('completed')" class="py-4 px-6 font-medium text-sm inline-flex items-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors">
                        <i class="fas fa-check-circle mr-2"></i>
                        Completed Evaluations
                    </button>
                </nav>
            </div>

            <!-- Pending Evaluations Section -->
            <div id="pending-evaluations" class="p-6">
                @if(isset($pendingReflections) && count($pendingReflections) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Training</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Submitted On</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingReflections as $reflection)
                                <tr class="hover:bg-gray-50 transition-colors">
                                   
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reflection->employee_data['first_name'] ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $reflection->employee_data['email'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $reflection->seminar->title }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reflection->seminar->date_time)->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reflection->created_at)->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reflection->created_at)->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="openEvaluationModal({{ $reflection->id }})" class="inline-flex items-center px-3 py-1.5 border border-blue-600 text-blue-600 rounded-md text-sm font-medium hover:bg-blue-50 transition-colors">
                                            <i class="fas fa-edit mr-1.5"></i> Review
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 text-blue-500 mb-4">
                            <i class="fas fa-clipboard-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No Pending Evaluations</h3>
                        <p class="text-gray-500 max-w-md mx-auto">All employee training reflections have been evaluated. Check the completed tab to view previous evaluations.</p>
                    </div>
                @endif
            </div>

            <!-- Completed Evaluations Section -->
            <div id="completed-evaluations" class="p-6 hidden">
                @if(isset($completedReflections) && count($completedReflections) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Employee</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Training</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Score</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Evaluated By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($completedReflections as $reflection)
                                <tr class="hover:bg-gray-50 transition-colors">

                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reflection->employee_data['first_name'] ?? 'Unknown' }}
                                                    {{ $reflection->employee_data['last_name'] ?? 'User' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $reflection->employee_data['email'] ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $reflection->seminar->title }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reflection->seminar->date_time)->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $reflection->evaluation_score >= 4 ? 'bg-green-100 text-green-800' :
                                              ($reflection->evaluation_score >= 3 ? 'bg-blue-100 text-blue-800' :
                                              ($reflection->evaluation_score >= 2 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $reflection->evaluation_score }}/5
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"></div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reflection->evaluated_at)->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="viewEvaluation({{ $reflection->id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-eye mr-1.5"></i> View Details
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-500 mb-4">
                            <i class="fas fa-clipboard text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No Completed Evaluations</h3>
                        <p class="text-gray-500 max-w-md mx-auto">No reflections have been evaluated yet. Check the pending tab to evaluate submitted reflections.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Evaluation Modal -->
<div id="evaluation-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="relative bg-white rounded-lg max-w-2xl w-full shadow-xl transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Review Reflection</h3>
                    <button type="button" onclick="closeEvaluationModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                <!-- Employee and Training Info -->
                <div class="bg-gray-50 p-4 rounded-lg mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Employee</h4>
                        <p class="text-base font-medium text-gray-900" id="employee-name">Loading...</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Training</h4>
                        <p class="text-base font-medium text-gray-900" id="training-title">Loading...</p>
                    </div>
                </div>

                <!-- Reflection Content -->
                <div class="mb-5">
                    <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Reflection</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p id="reflection-text" class="text-sm text-gray-700">Loading reflection content...</p>
                    </div>
                </div>

                <!-- Attached Document -->
                <div class="mb-5" id="attachment-section">
                    <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Attached Document</h4>
                    <div class="bg-gray-50 p-3 rounded-lg flex items-center">
                        <div class="flex items-center flex-grow">
                            <i class="fas fa-file-pdf text-red-500 text-lg mr-3"></i>
                            <span id="attachment-name" class="text-sm">reflection-document.pdf</span>
                        </div>
                        <a href="#" target="_blank" id="download-attachment" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-download mr-1.5"></i> Download
                        </a>
                    </div>
                </div>

                <!-- Evaluation Form -->
                <form id="evaluation-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="reflection-id" name="reflection_id">

                    <div class="space-y-5">
                        <!-- Score Rating -->
                        <div>
                            <label for="evaluation-score" class="block text-xs font-medium uppercase text-gray-500 mb-2">Comprehension Score</label>
                            <div class="evaluation-stars flex items-center bg-gray-50 p-3 rounded-lg">
                                <div class="flex space-x-1">
                                    <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none" data-value="1">★</button>
                                    <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none" data-value="2">★</button>
                                    <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none" data-value="3">★</button>
                                    <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none" data-value="4">★</button>
                                    <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none" data-value="5">★</button>
                                </div>
                                <span id="score-display" class="ml-3 text-sm text-gray-500">Select a score</span>
                                <input type="hidden" id="evaluation-score" name="evaluation_score" required>
                            </div>
                        </div>

                        <!-- Evaluation Type -->
                        <div>
                            <label for="evaluation-type" class="block text-xs font-medium uppercase text-gray-500 mb-2">Evaluation Type</label>
                            <select id="evaluation-type" name="evaluation_type" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="">Select type...</option>
                                <option value="excellent">Excellent - Thorough understanding</option>
                                <option value="satisfactory">Satisfactory - Good understanding</option>
                                <option value="average">Average - Basic understanding</option>
                                <option value="needs_improvement">Needs Improvement - Limited understanding</option>
                                <option value="unsatisfactory">Unsatisfactory - Does not meet requirements</option>
                            </select>
                        </div>

                        <!-- Feedback Comments -->
                        <div>
                            <label for="evaluation-comments" class="block text-xs font-medium uppercase text-gray-500 mb-2">Feedback Comments</label>
                            <textarea id="evaluation-comments" name="evaluation_comments" rows="4" class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Provide detailed feedback to the employee..."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeEvaluationModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="submitEvaluation()" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Submit Evaluation
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Evaluation Modal -->
<div id="view-evaluation-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="relative bg-white rounded-lg max-w-2xl w-full shadow-xl transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="view-modal-title">Evaluation Details</h3>
                    <button type="button" onclick="closeViewEvaluationModal()" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                <!-- Employee and Training Info -->
                <div class="bg-gray-50 p-4 rounded-lg mb-5 flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Employee</h4>
                        <p class="text-base font-medium text-gray-900" id="view-employee-name">Loading...</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase">Training</h4>
                        <p class="text-base font-medium text-gray-900" id="view-training-title">Loading...</p>
                    </div>
                </div>

                <!-- Reflection Content -->
                <div class="mb-5">
                    <h4 class="text-xs font-medium text-gray-500 uppercase mb-2">Reflection</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p id="view-reflection-text" class="text-sm text-gray-700">Loading reflection content...</p>
                    </div>
                </div>

                <!-- Evaluation Details -->
                <div class="bg-blue-50 p-4 rounded-lg mb-5 space-y-3">
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Evaluation Score</h4>
                        <div class="flex items-center">
                            <div id="view-stars" class="flex text-yellow-400 mr-2"></div>
                            <span id="view-score" class="text-sm font-medium text-gray-900">Loading...</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Evaluation Type</h4>
                        <p id="view-evaluation-type" class="text-sm text-gray-700">Loading...</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Feedback Comments</h4>
                        <p id="view-evaluation-comments" class="text-sm text-gray-700">Loading...</p>
                    </div>
                </div>

                <!-- Evaluator Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200" id="view-evaluator-avatar" src="" alt="Evaluator">
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xs font-medium text-gray-500 uppercase">Evaluated By</h4>
                            <p id="view-evaluator-name" class="text-sm font-medium text-gray-900">Loading...</p>
                            <p id="view-evaluated-date" class="text-xs text-gray-500">Loading...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="button" onclick="closeViewEvaluationModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
 // Tab switching functionality
function switchTab(tabName) {
    // Hide all content
    document.getElementById('pending-evaluations').classList.add('hidden');
    document.getElementById('completed-evaluations').classList.add('hidden');

    // Remove active class from all tabs
    document.getElementById('pending-tab').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('pending-tab').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('completed-tab').classList.remove('border-blue-600', 'text-blue-600');
    document.getElementById('completed-tab').classList.add('border-transparent', 'text-gray-500');

    // Show selected content and activate tab
    if (tabName === 'pending') {
        document.getElementById('pending-evaluations').classList.remove('hidden');
        document.getElementById('pending-tab').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('pending-tab').classList.remove('border-transparent', 'text-gray-500');
    } else {
        document.getElementById('completed-evaluations').classList.remove('hidden');
        document.getElementById('completed-tab').classList.add('border-blue-600', 'text-blue-600');
        document.getElementById('completed-tab').classList.remove('border-transparent', 'text-gray-500');
    }
}

// Modal functionality
function openEvaluationModal(reflectionId) {
    // Clear previous form values
    resetEvaluationForm();

    // Set the reflection ID in the hidden input
    document.getElementById('reflection-id').value = reflectionId;

    // Show modal
    document.getElementById('evaluation-modal').classList.remove('hidden');

    // Fetch reflection data via AJAX
    fetchReflectionData(reflectionId);
}

function closeEvaluationModal() {
    document.getElementById('evaluation-modal').classList.add('hidden');
}

function viewEvaluation(reflectionId) {
    // Fetch evaluation details via AJAX
    fetchEvaluationData(reflectionId);

    // Show modal
    document.getElementById('view-evaluation-modal').classList.remove('hidden');
}

function closeViewEvaluationModal() {
    document.getElementById('view-evaluation-modal').classList.add('hidden');
}

function fetchReflectionData(reflectionId) {
    // Show loading state
    document.getElementById('employee-name').textContent = 'Loading...';
    document.getElementById('training-title').textContent = 'Loading...';
    document.getElementById('reflection-text').textContent = 'Loading...';

    // Hide attachment section by default
    document.getElementById('attachment-section').classList.add('hidden');

    // Make AJAX request
    fetch(`/api/reflections/${reflectionId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update the modal with reflection data
            const employeeName = `${data.employee.first_name} ${data.employee.last_name}`.trim();
            document.getElementById('employee-name').textContent = employeeName || 'Unknown User';

            // Handle training title - make it more descriptive
            const trainingTitle = data.seminar.title || `Training Session ${data.seminar.id}`;
            document.getElementById('training-title').textContent = trainingTitle;

            // Display the clean reflection text without API_EMPLOYEE_ID prefix
            document.getElementById('reflection-text').textContent = data.comment || 'No reflection provided';

            // Check if there's an attachment
            if (data.document_path) {
                document.getElementById('attachment-section').classList.remove('hidden');
                const fileName = data.document_path.split('/').pop();
                document.getElementById('attachment-name').textContent = fileName;
                document.getElementById('download-attachment').href = `/storage/${data.document_path}`;
            } else {
                document.getElementById('attachment-section').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error fetching reflection data:', error);
            document.getElementById('reflection-text').textContent = 'Error loading reflection data. Please try again.';
        });
}
// AJAX function to fetch evaluation data
function fetchEvaluationData(reflectionId) {
    // Show loading state
    document.getElementById('view-employee-name').textContent = 'Loading...';
    document.getElementById('view-training-title').textContent = 'Loading...';
    document.getElementById('view-reflection-text').textContent = 'Loading...';
    document.getElementById('view-evaluation-comments').textContent = 'Loading...';
    document.getElementById('view-score').textContent = 'Loading...';
    document.getElementById('view-evaluation-type').textContent = 'Loading...';
    document.getElementById('view-evaluator-name').textContent = 'Loading...';
    document.getElementById('view-evaluated-date').textContent = 'Loading...';

    // Make AJAX request
    fetch(`/api/evaluations/${reflectionId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Evaluation data:', data); // For debugging

            // Update the view modal with reflection data
            document.getElementById('view-employee-name').textContent = data.reflection.employee.first_name + ' ' + data.reflection.employee.last_name;
            document.getElementById('view-training-title').textContent = data.reflection.seminar.title;
            document.getElementById('view-reflection-text').textContent = data.reflection.comment;

            // Set evaluation score and stars
            const score = data.evaluation.evaluation_score;
            document.getElementById('view-score').textContent = score + '/5';

            // Update stars display
            const starsContainer = document.getElementById('view-stars');
            starsContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.textContent = '★';
                star.className = i <= score ? 'text-yellow-400' : 'text-gray-300';
                starsContainer.appendChild(star);
            }

            // Set other evaluation details
            let evaluationType = '';
            switch(data.evaluation.evaluation_type) {
                case 'excellent':
                    evaluationType = 'Excellent - Thorough understanding';
                    break;
                case 'satisfactory':
                    evaluationType = 'Satisfactory - Good understanding';
                    break;
                case 'average':
                    evaluationType = 'Average - Basic understanding';
                    break;
                case 'needs_improvement':
                    evaluationType = 'Needs Improvement - Limited understanding';
                    break;
                case 'unsatisfactory':
                evaluationType = 'Unsatisfactory - Does not meet requirements';
                    break;
                default:
                    evaluationType = data.evaluation.evaluation_type;
            }
            document.getElementById('view-evaluation-type').textContent = evaluationType;
            document.getElementById('view-evaluation-comments').textContent = data.evaluation.evaluation_comments;

            // Set evaluator information
            if (data.evaluator) {
                document.getElementById('view-evaluator-name').textContent = data.evaluator.name;
                document.getElementById('view-evaluator-avatar').src = `/storage/${data.evaluator.avatar}`;
                document.getElementById('view-evaluated-date').textContent = new Date(data.evaluation.evaluated_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } else {
                document.getElementById('view-evaluator-name').textContent = 'System';
                document.getElementById('view-evaluator-avatar').src = '/images/default-avatar.png';
                document.getElementById('view-evaluated-date').textContent = new Date(data.evaluation.evaluated_at).toLocaleDateString();
            }
        })
        .catch(error => {
            console.error('Error fetching evaluation data:', error);
            // Show error message in modal
            document.getElementById('view-reflection-text').textContent = 'Error loading evaluation data. Please try again.';
        });
}

// Function to reset the evaluation form
function resetEvaluationForm() {
    // Clear form fields
    document.getElementById('evaluation-form').reset();
    document.getElementById('evaluation-score').value = '';

    // Reset stars
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach(star => {
        star.classList.remove('text-yellow-400');
        star.classList.add('text-gray-300');
    });

    document.getElementById('score-display').textContent = 'Select a score';
}

// Function to handle star rating selection
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            document.getElementById('evaluation-score').value = value;

            // Update star appearance
            stars.forEach(s => {
                const starValue = parseInt(s.dataset.value);
                if (starValue <= value) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });

            // Update score display text
            const scoreDisplay = document.getElementById('score-display');
            scoreDisplay.textContent = value + '/5';

            // Set evaluation type based on score
            const evaluationType = document.getElementById('evaluation-type');
            switch(value) {
                case 5:
                    evaluationType.value = 'excellent';
                    break;
                case 4:
                    evaluationType.value = 'satisfactory';
                    break;
                case 3:
                    evaluationType.value = 'average';
                    break;
                case 2:
                    evaluationType.value = 'needs_improvement';
                    break;
                case 1:
                    evaluationType.value = 'unsatisfactory';
                    break;
            }
        });
    });
});

// Function to submit the evaluation
function submitEvaluation() {
    const form = document.getElementById('evaluation-form');
    const formData = new FormData(form);

    // Validate form
    const score = formData.get('evaluation_score');
    const type = formData.get('evaluation_type');
    const comments = formData.get('evaluation_comments');

    if (!score) {
        alert('Please select a score for the reflection.');
        return;
    }

    if (!type) {
        alert('Please select an evaluation type.');
        return;
    }

    if (!comments || comments.trim() === '') {
        alert('Please provide feedback comments.');
        return;
    }

    // Submit form data via AJAX
    fetch('/auth/others/reflection/evaluate', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Close modal
            closeEvaluationModal();

            // Show success message
            alert('Evaluation submitted successfully!');

            // Refresh the page to update lists
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error submitting evaluation:', error);
        alert('An error occurred while submitting the evaluation. Please try again.');
    });
}
</script>
@endsection
