@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')
<style>
    .skill-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #e5e7eb;
        overflow: hidden;
    }

    .skill-progress {
        height: 100%;
        border-radius: 4px;
    }

    .technical { background-color: #3b82f6; }
    .safety { background-color: #10b981; }
    .leadership { background-color: #8b5cf6; }
</style>
<div class="container mx-auto px-4 py-8 max-w-full w-full">
    <!-- Header -->
    <header class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Competency Management</h1>
            <p class="text-gray-600 text-lg">Empowering Talent Development</p>
        </div>

    </header>

    <!-- Main Content Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Employee Profile Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
            <div class="text-center">
                <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user text-4xl text-blue-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Employee Details</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                        <input type="text" name="full_name" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg" placeholder="Enter full name">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <div class="relative">
                        <i class="fas fa-building absolute left-3 top-3 text-gray-400"></i>
                        <select name="department" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg">
                            <option value="Human Resource">Human Resources</option>
                            <option value="Logistics">Logistic</option>
                            <option value="Core">Core</option>
                            <option value="Finance">Finance</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Competency Assessment -->
        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
            <div class="text-center">
                <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-4xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Skill Assessment</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skill Category</label>
                    <div class="relative">
                        <i class="fas fa-tags absolute left-3 top-3 text-gray-400"></i>
                        <select name="skill_category" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg">
                            <option value="Technical Skills">Technical Skills</option>
                            <option value="Safety Skills">Soft Skills</option>
                            <option value="Leadership">Leadership</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Programming">Programming</option>
                            <option value="Management">Management</option>
                            <option value="Supply Chain">Supply Chain</option>
                            <option value="Software Engineering">Software Engineering</option>
                            <option value="Strategic Planning">Strategic Planning</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Promotion</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="proficiency" class="text-green-600 focus:ring-green-500">
                            <span>Beginner</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="proficiency" class="text-green-600 focus:ring-green-500">
                            <span>Intermediate</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="proficiency" class="text-green-600 focus:ring-green-500">
                            <span>Expert</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Development Plan -->
        <div class="bg-white rounded-2xl shadow-xl p-6 space-y-6">
            <div class="text-center">
                <div class="mx-auto w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-rocket text-4xl text-purple-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Growth Plan</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Training Objectives (send via Gmail)</label>
                    <textarea id="trainingObjectives" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent h-24" placeholder="Describe development goals and training needs"></textarea>
                </div>

                <input type="text" id="recipientEmail" name="recipientEmail" class="hidden">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Completion</label>
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-3 top-3 text-gray-400"></i>
                        <input type="date" id="targetCompletion" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="text-right">
                    <button id="sendEmailBtn" class="px-6 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        Send via Gmail
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Competency Overview -->
    <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex flex-wrap items-center justify-between -mt-2 -ml-4 sm:flex-nowrap">
                <div class="mt-2 ml-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Employee Skills Matrix</h3>
                </div>

                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Employee
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Department
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Technical Skills
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Safety Skills
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Leadership
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Task and AI Insight
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (!empty($employees))
                                @foreach ($employees as $employee)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $employee['image_url'] ?? 'https://via.placeholder.com/100' }}" alt="{{ $employee['employee_name'] }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $employee['employee_name'] ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $employee['email'] ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $employee['department'] ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-y-1 flex-col">
                                            <div class="w-full flex justify-between mb-1">
                                                <span class="text-xs font-medium text-gray-700">{{ $employee['technical_skill'] }}%</span>
                                            </div>
                                            <div class="w-full skill-bar">
                                                <div class="skill-progress technical" style="width: {{ $employee['technical_skill'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-y-1 flex-col">
                                            <div class="w-full flex justify-between mb-1">
                                                <span class="text-xs font-medium text-gray-700">{{ $employee['safety_skill'] }}%</span>
                                            </div>
                                            <div class="w-full skill-bar">
                                                <div class="skill-progress safety" style="width: {{ $employee['safety_skill'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-y-1 flex-col">
                                            <div class="w-full flex justify-between mb-1">
                                                <span class="text-xs font-medium text-gray-700">{{ $employee['leadership_skill'] }}%</span>
                                            </div>
                                            <div class="w-full skill-bar">
                                                <div class="skill-progress leadership" style="width: {{ $employee['leadership_skill'] }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="flex gap-2">
                                        <button class="edit-btn p-2 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                data-id="{{ $employee['id'] }}"
                                                data-name="{{ $employee['employee_name'] }}"
                                                data-email="{{ $employee['email'] }}"
                                                data-department="{{ $employee['department'] }}"
                                                data-skill="{{ $employee['skill_category'] ?? 'N/A' }}"
                                                data-proficiency="{{ $employee['proficiency'] ?? 'N/A' }}">
                                            <!-- Pencil Icon for Edit/Send Task -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6m2-8l4 4m0 0l-4 4m0 0l-6-6M16 5l-4 4m-4 0L4 7" />
                                            </svg>
                                        </button>

                                        <button class="report-btn p-2 text-white bg-indigo-600 rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                data-id="{{ $employee['id'] }}">
                                                <i class="fas fa-robot"></i> <!-- Robot Icon -->

                                        </button>
                                    </td>

                                </tr>
                                  @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No employee data available.
                                        </td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Fetch data attributes from the clicked button
                const employeeId = this.getAttribute("data-id");
                const fullName = this.getAttribute("data-name");
                const employeeEmail = this.getAttribute("data-email");
                const department = this.getAttribute("data-department");
                const skillCategory = this.getAttribute("data-skill");
                const proficiency = this.getAttribute("data-proficiency");

                // Populate Full Name
                const fullNameInput = document.querySelector("input[name='full_name']");
                if (fullNameInput) fullNameInput.value = fullName;

                // Populate Email (Hidden Field)
                const emailInput = document.getElementById("recipientEmail");
                if (emailInput) emailInput.value = employeeEmail;

                // Populate Department (Dropdown)
                const departmentSelect = document.querySelector("select[name='department']");
                if (departmentSelect) departmentSelect.value = department;

                // Populate Skill Category (Dropdown)
                const skillSelect = document.querySelector("select[name='skill_category']");
                if (skillSelect) skillSelect.value = skillCategory;

                // Populate Proficiency (Radio Button)
                const proficiencyRadios = document.querySelectorAll("input[name='proficiency']");
                if (proficiencyRadios) {
                    proficiencyRadios.forEach(radio => {
                        radio.checked = radio.nextElementSibling.textContent.trim() === proficiency;
                    });
                }

                // Debugging Log
                console.log("Employee Email:", employeeEmail);
            });
        });
    });
</script>



<script>
   // Save this in a JS file in your public or resources directory
document.addEventListener('DOMContentLoaded', function() {
    const sendEmailBtn = document.getElementById('sendEmailBtn');

    if (sendEmailBtn) {
        sendEmailBtn.addEventListener('click', sendGrowthPlanEmail);
    }

    function sendGrowthPlanEmail() {
        // Get form values
        const trainingObjectives = document.getElementById('trainingObjectives').value;
        const recipientEmail = document.getElementById('recipientEmail').value;
        const targetCompletion = document.getElementById('targetCompletion').value;

        // Validate inputs
        if (!trainingObjectives.trim()) {
            alert('Please enter training objectives');
            return;
        }

        if (!recipientEmail.trim()) {
            alert('Please enter a recipient email');
            return;
        }

        // Show loading state
        const originalBtnText = sendEmailBtn.innerHTML;
        sendEmailBtn.innerHTML = 'Sending...';
        sendEmailBtn.disabled = true;

        // Get CSRF token for Laravel
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make AJAX request
        fetch('/send-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                trainingObjectives: trainingObjectives,
                recipientEmail: recipientEmail,
                targetCompletion: targetCompletion
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email sent successfully!');
                // Reset form
                document.getElementById('trainingObjectives').value = '';
                document.getElementById('recipientEmail').value = '';
                document.getElementById('targetCompletion').value = '';
            } else {
                alert('Failed to send email: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the email.');
        })
        .finally(() => {
            // Restore button state
            sendEmailBtn.innerHTML = originalBtnText;
            sendEmailBtn.disabled = false;
        });
    }
});
</script>

<script>
  // Add this to your blade template or JavaScript file
$(document).ready(function() {
    // Debug output to verify the script is running
    console.log("Script initialized - looking for report buttons");

    // Log how many buttons we found
    console.log("Found " + $('.report-btn').length + " report buttons");

    // Use direct event binding with strong selector
    $('body').on('click', '.report-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Debug which button was clicked
        console.log("Button clicked with ID: " + $(this).data('id'));

        const empId = $(this).data('id');

        if (!empId) {
            console.error("Employee ID not found on button");
            return;
        }

        // Show loading indicator
        Swal.fire({
            title: 'Generating Competency Insight...',
            text: 'AI is analyzing the employee\'s data...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        // Make the AJAX request
        $.ajax({
            type: "GET",
            url: "/api/employee-competency-ai/" + empId,
            dataType: 'json',
            success: function(response) {
                let data;
                try {
                    // Handle both pre-parsed and string JSON responses
                    data = typeof response === 'string' ? JSON.parse(response) : response;
                } catch (parseError) {
                    console.error("Error parsing JSON:", parseError);
                    Swal.fire({
                        title: 'Error',
                        text: "Invalid response format received.",
                        icon: 'error'
                    });
                    return;
                }

                                    if (data && data.length === 1) {
                        let recommendation = data[0].Recommendation || '';

                        // Fix bullets to new lines
                        recommendation = recommendation.replace(/•\s*/g, '<br>• ');

                        Swal.fire({
                            title: "AI Competency Insight",
                            html: `
                                <div class="text-left mb-4">
                                    <h3 class="mb-2">Employee: ${data[0].Employee}</h3>
                                    <h4 class="mb-2">Department: ${data[0].Department}</h4>
                                    <div class="mt-3 mb-3">
                                        <h4 class="mb-2">Current Competency Level:
                                            <span class="${getCompetencyLevelClass(data[0].CompetencyLevel)}">
                                                ${data[0].CompetencyLevel}
                                            </span>
                                        </h4>
                                    </div>
                                    <div class="mt-3 mb-3">
                                        <h4 class="mb-2">AI Insight:</h4>
                                        <p>${data[0].Insight}</p>
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="mb-2">AI Recommendation:</h4>
                                        <p>${recommendation}</p>
                                    </div>
                                </div>
                            `,
                            customClass: {
                                popup: 'swal-wide',
                                content: 'text-left'
                            },
                            icon: 'info',
                            confirmButtonText: 'Close',
                            showConfirmButton: true
                        });
                    }
                        else {
                    Swal.fire({
                        text: "No competency insight available.",
                        icon: 'warning'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);

                Swal.fire({
                    title: 'Error',
                    text: "Something went wrong while generating the insight.",
                    icon: 'error'
                });
            }
        });
    });

    // Helper function to apply color classes based on competency level
    function getCompetencyLevelClass(level) {
        if (!level) return '';

        switch(String(level).toLowerCase()) {
            case 'beginner':
                return 'text-warning';
            case 'intermediate':
                return 'text-info';
            case 'advanced':
                return 'text-success';
            default:
                return '';
        }
    }

    // Add CSS for wider SweetAlert modal
    $('<style>.swal-wide { width: 850px !important; max-width: 90% !important; }</style>').appendTo('head');

    // Make sure the buttons are actually clickable by setting a pointer cursor
    $('<style>.report-btn { cursor: pointer !important; }</style>').appendTo('head');
});
</script>


@endsection
