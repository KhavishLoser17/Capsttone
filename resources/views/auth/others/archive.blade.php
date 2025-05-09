@extends('layouts.hr3-admin')

@section('title')
    Training Archives
@endsection

@section('content')
<div class="py-6 px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Training Archives</h1>
        <p class="text-gray-600">View and manage archived training records</p>
    </div>

    <!-- Tab navigation -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px">
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-blue-500 rounded-t-lg text-blue-600 tab-button active" data-target="schedules">
                    Training Schedules
                </button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-button" data-target="hr2">
                    Training
                </button>
            </li>
            <li class="mr-2">
                <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 tab-button" data-target="video">
                    Training Videos
                </button>
            </li>
        </ul>
    </div>

    <!-- Training Schedules Archive Table -->
    <div id="schedules-tab" class="tab-content">
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trainer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facility</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted On</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($archivedSchedules as $schedule)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $schedule->training_title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->training_type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $schedule->start_date->format('M d, Y') }}<br>
                                {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->trainer }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->getFacilityDisplayAttribute() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $schedule->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900"
                                        onclick="restoreSchedule('{{ $schedule->id }}')">
                                        Restore
                                    </button>
                                    <button class="text-red-600 hover:text-red-900"
                                        onclick="confirmDelete('{{ $schedule->id }}', 'schedule')">
                                        Delete Permanently
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No archived training schedules found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">
                {{ $archivedSchedules->links() }}
            </div>
        </div>
    </div>

    <!-- HR2 Trainings Archive Table -->
    <div id="hr2-tab" class="tab-content hidden">
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted On</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($archivedHR2Trainings as $training)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $training->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $training->instructor }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $training->department }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $training->date ? $training->date->format('M d, Y') : 'No date available' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $training->dueDate ? $training->dueDate->format('M d, Y') : 'No due date available' }}
                            </td>                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($training->budget, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $training->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900"
                                        onclick="restoreHR2Training('{{ $training->id }}')">
                                        Restore
                                    </button>
                                    <button class="text-red-600 hover:text-red-900"
                                        onclick="confirmDelete('{{ $training->id }}', 'hr2')">
                                        Delete Permanently
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No archived HR2 trainings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">
                {{ $archivedHR2Trainings->links() }}
            </div>
        </div>
    </div>

    <div id="video-tab" class="tab-content hidden">
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted On</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($archivedVideoHR2s as $video)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $video->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $video->instructor }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $video->department }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $video->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($video->date_time)->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($video->estimated_budget, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $video->deleted_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900"
                                        onclick="restoreVideoHR2('{{ $video->id }}')">
                                        Restore
                                    </button>
                                    <button class="text-red-600 hover:text-red-900"
                                        onclick="confirmDelete('{{ $video->id }}', 'video')">
                                        Delete Permanently
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No archived training videos found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4">
                {{ $archivedVideoHR2s->links() }}
            </div>
        </div>
    </div>


    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900">Confirm Permanent Deletion</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to permanently delete this record? This action cannot be undone.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Delete Permanently
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and hide all contents
                tabButtons.forEach(btn => btn.classList.remove('active', 'border-blue-500', 'text-blue-600'));
                tabButtons.forEach(btn => btn.classList.add('border-transparent'));
                tabContents.forEach(content => content.classList.add('hidden'));

                // Add active class to clicked button and show corresponding content
                button.classList.add('active', 'border-blue-500', 'text-blue-600');
                button.classList.remove('border-transparent');
                const target = button.getAttribute('data-target');
                document.getElementById(`${target}-tab`).classList.remove('hidden');
            });
        });
    });

    // Function to restore training schedule
    function restoreSchedule(id) {
        if (confirm('Are you sure you want to restore this training schedule?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/restore-schedule/${id}`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Function to restore HR2 training
    function restoreHR2Training(id) {
        if (confirm('Are you sure you want to restore this HR2 training?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/restore-hr2/${id}`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Function to restore VideoHR2 training
    function restoreVideoHR2(id) {
        if (confirm('Are you sure you want to restore this training video?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/restore-video-hr2/${id}`;
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Variables to store delete information
    let deleteId = null;
    let deleteType = null;
    const modal = document.getElementById('confirmationModal');
    const cancelBtn = document.getElementById('cancelDelete');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    // Function to show delete confirmation modal
    function confirmDelete(id, type) {
        deleteId = id;
        deleteType = type;
        modal.classList.remove('hidden');
    }

    // Cancel deletion
    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        deleteId = null;
        deleteType = null;
    });

    // Confirm permanent deletion
    confirmBtn.addEventListener('click', () => {
        if (deleteId && deleteType) {
            const form = document.createElement('form');
            form.method = 'POST';

            if (deleteType === 'schedule') {
                form.action = `/destroy-schedule-permanent/${deleteId}`;
            } else if (deleteType === 'hr2') {
                form.action = `/destroy-hr2-permanent/${deleteId}`;
            } else if (deleteType === 'video') {
                form.action = `/destroy-video-hr2-permanent/${deleteId}`;
            }

            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }

        modal.classList.add('hidden');
    });
</script>
@endsection
