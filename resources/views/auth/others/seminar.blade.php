@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-2 border-b border-gray-200 sm:px-6 flex items-center justify-between">
            <div>
                <h3 class="text-3xl leading-6 font-medium text-gray-900">
                    Training Management
                </h3>
                <p class="mt-1 max-w-2xl text-gray-500">
                    Book training rooms, seminar halls, and physical training areas
                </p>
            </div>
            <div>
                @if(Auth::user()->emp_acc_role == 'admin')
                <button type="button" onclick="openAddScheduleModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                    + Add Schedule
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Sessions -->
<div class="mt-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Upcoming Training Sessions
                </h3>
                <p class="mt-1 max-w-2xl text-gray-500">
                    View and manage upcoming training events
                </p>
            </div>
            <div>
                <button class="font-medium text-indigo-600 hover:text-indigo-500">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Training Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Facility
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Department
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Trainer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trainings as $training)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $training->training_title }}</div>
                            <div class="text-gray-500">{{ $training->training_type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $training->start_date->format('M d, Y') }}</div>
                            <div class="text-gray-500">{{ $training->start_time->format('H:i') }} - {{ $training->end_time->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $training->getFacilityDisplayAttribute() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $training->department }}</div>                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full" src="/api/placeholder/32/32" alt="">
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">
                                        {{ $training->trainer }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $training->start_date->isPast() ? 'Completed' : 'Confirmed' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                            <a href="javascript:void(0)" onclick="openEditScheduleModal({{ $training->id }})" class="text-gray-600 hover:text-gray-900 mr-3">Edit</a>
                            <form action="{{ route('trainings.destroy', $training->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to Archive this training?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No training schedules found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-5 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Facility Calendar -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Facility Calendar
            </h3>
            <p class="mt-1 max-w-2xl text-gray-500">
                Overview of all facility bookings
            </p>
        </div>
        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">{{ $currentMonth['name'] }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('auth.others.seminar', ['month' => date('Y-m', strtotime('-1 month'))]) }}" class="p-1.5 rounded-full hover:bg-gray-100">
                        <i class="fas fa-chevron-left text-gray-600"></i>
                    </a>
                    <a href="{{ route('auth.others.seminar', ['month' => date('Y-m', strtotime('+1 month'))]) }}" class="p-1.5 rounded-full hover:bg-gray-100">
                        <i class="fas fa-chevron-right text-gray-600"></i>
                    </a>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-1 text-center">
                <div class="font-medium text-gray-500 uppercase">Sun</div>
                <div class="font-medium text-gray-500 uppercase">Mon</div>
                <div class="font-medium text-gray-500 uppercase">Tue</div>
                <div class="font-medium text-gray-500 uppercase">Wed</div>
                <div class="font-medium text-gray-500 uppercase">Thu</div>
                <div class="font-medium text-gray-500 uppercase">Fri</div>
                <div class="font-medium text-gray-500 uppercase">Sat</div>

                <!-- Previous month days -->
                @php
                    $daysInPrevMonth = Carbon\Carbon::now()->subMonth()->daysInMonth;
                    $firstDayOfWeek = $currentMonth['firstDayOfWeek'];
                    $daysPrevMonth = $firstDayOfWeek > 0 ? $firstDayOfWeek : 0;
                @endphp

                @for ($i = 0; $i < $daysPrevMonth; $i++)
                    <div class="p-2 text-gray-400">{{ $daysInPrevMonth - $daysPrevMonth + $i + 1 }}</div>
                @endfor

                <!-- Current month days -->
                @for ($day = 1; $day <= $currentMonth['days']; $day++)
                    @php
                        $isToday = $day == now()->day && now()->month == date('n') && now()->year == date('Y');
                        $hasEvents = isset($calendarEventsByDay[$day]);
                    @endphp

                    <div class="p-2 relative {{ $isToday ? 'bg-indigo-50 rounded font-medium text-indigo-800' : '' }}">
                        {{ $day }}
                        @if($hasEvents)
                            @foreach($calendarEventsByDay[$day] as $event)
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-{{ $event['color'] }}-500"></div>
                            @endforeach
                        @endif
                    </div>
                @endfor

                <!-- Next month days -->
                @php
                    $totalDaysShown = $daysPrevMonth + $currentMonth['days'];
                    $daysNextMonth = 42 - $totalDaysShown;
                    $daysNextMonth = $daysNextMonth > 7 ? 7 : $daysNextMonth;
                @endphp

                @for ($i = 1; $i <= $daysNextMonth; $i++)
                    <div class="p-2 text-gray-400">{{ $i }}</div>
                @endfor
            </div>

            <!-- Calendar Legend -->
            <div class="mt-4 flex flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-500 mr-1"></div>
                    <span>Physical Training</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-1"></div>
                    <span>Seminar</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-red-500 mr-1"></div>
                    <span>Workshop</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-yellow-500 mr-1"></div>
                    <span>Conference</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-purple-500 mr-1"></div>
                    <span>Assessment</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Spaces -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Available Spaces Today
            </h3>
            <p class="mt-1 max-w-2xl text-gray-500">
                Current status of all training facilities
            </p>
        </div>
        <div class="divide-y divide-gray-200">
            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-green-100 flex items-center justify-center">
                        <i class="fas fa-dumbbell text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Physical Training Area A</h4>
                        <p class="text-gray-500">Capacity: 25 | Equipment: Full</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
            </div>

            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-chalkboard text-gray-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Seminar Hall 1</h4>
                        <p class="text-gray-500">Capacity: 50 | Equipment: Projector, Audio</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-red-100 text-red-800">Booked</span>
            </div>

            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-green-100 flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Seminar Hall 2</h4>
                        <p class="text-gray-500">Capacity: 40 | Equipment: Full</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
            </div>

            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-green-100 flex items-center justify-center">
                        <i class="fas fa-running text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Physical Training Area B</h4>
                        <p class="text-gray-500">Capacity: 15 | Equipment: Basic</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">Available</span>
            </div>

            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-desktop text-gray-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Computer Lab</h4>
                        <p class="text-gray-500">Capacity: 30 | Equipment: Full</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-red-100 text-red-800">Booked</span>
            </div>

            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-users text-gray-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Conference Room A</h4>
                        <p class="text-gray-500">Capacity: 20 | Equipment: Projector</p>
                    </div>
                </div>
                <span class="px-2 inline-flex leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Maintenance</span>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div id="addScheduleModal" class="fixed inset-0 z-[99999] hidden overflow-y-auto">
<div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="scheduleForm" method="POST" action="{{ route('seminar.store') }}"  enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-calendar-plus text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Add Training Schedule
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="trainingTitle" class="block text-sm font-medium text-gray-700">Training Title</label>
                                    <input type="text" name="trainingTitle" id="trainingTitle" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="trainingType" class="block text-sm font-medium text-gray-700">Training Type</label>
                                    <select id="trainingType" name="trainingType" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a type</option>
                                        <option value="Physical Training">Physical Training</option>
                                        <option value="Seminar">Seminar</option>
                                        <option value="Workshop">Workshop</option>
                                        <option value="Conference">Conference</option>
                                        <option value="Assessment">Assessment</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                                    <select id="department" name="department" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a department</option>
                                        <option value="All Department">All Department</option>
                                        <option value="Human Resource">Human Resource</option>
                                        <option value="Logistic">Logistic</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Core">Core</option>
                                        <option value="Administrative">Administrative</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="startDate" class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="startDate" id="startDate" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="trainer" class="block text-sm font-medium text-gray-700">Trainer</label>
                                        <input type="text" name="trainer" id="trainer" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time</label>
                                        <input type="time" name="startTime" id="startTime" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                                        <input type="time" name="endTime" id="endTime" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div>
                                    <label for="facility" class="block text-sm font-medium text-gray-700">Training Facility</label>
                                    <select id="facility" name="facility" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a facility</option>
                                        <option value="physical-a">Physical Training Area A (Capacity: 25)</option>
                                        <option value="seminar-1">Seminar Hall 1 (Capacity: 50)</option>
                                        <option value="seminar-2">Seminar Hall 2 (Capacity: 40)</option>
                                        <option value="physical-b">Physical Training Area B (Capacity: 15)</option>
                                        <option value="computer-lab">Computer Lab (Capacity: 30)</option>
                                        <option value="conference-a">Conference Room A (Capacity: 20)</option>
                                        <option value="outside-campus">Outside Campus</option>
                                    </select>
                                </div>
                                <div id="outsideCampusContainer" class="hidden">
                                    <label for="outsideCampusLocation" class="block text-sm font-medium text-gray-700">Outside Campus Location</label>
                                    <input type="text" name="outsideCampusLocation" id="outsideCampusLocation" placeholder="Enter full address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeAddScheduleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    {{-- FOR EDIT MODAL --}}
    <div id="editScheduleModal" class="fixed inset-0 z-[99999] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editScheduleForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_schedule_id" name="schedule_id">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-calendar-edit text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Edit Training Schedule
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="edit_trainingTitle" class="block text-sm font-medium text-gray-700">Training Title</label>
                                        <input type="text" name="trainingTitle" id="edit_trainingTitle" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit_trainingType" class="block text-sm font-medium text-gray-700">Training Type</label>
                                        <select id="edit_trainingType" name="trainingType" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select a type</option>
                                            <option value="Physical Training">Physical Training</option>
                                            <option value="Seminar">Seminar</option>
                                            <option value="Workshop">Workshop</option>
                                            <option value="Conference">Conference</option>
                                            <option value="Assessment">Assessment</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit_startDate" class="block text-sm font-medium text-gray-700">Date</label>
                                            <input type="date" name="startDate" id="edit_startDate" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_trainer" class="block text-sm font-medium text-gray-700">Trainer</label>
                                            <input type="text" name="trainer" id="edit_trainer" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit_startTime" class="block text-sm font-medium text-gray-700">Start Time</label>
                                            <input type="time" name="startTime" id="edit_startTime" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="edit_endTime" class="block text-sm font-medium text-gray-700">End Time</label>
                                            <input type="time" name="endTime" id="edit_endTime" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="edit_facility" class="block text-sm font-medium text-gray-700">Training Facility</label>
                                        <select id="edit_facility" name="facility" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">Select a facility</option>
                                            <option value="physical-a">Physical Training Area A (Capacity: 25)</option>
                                            <option value="seminar-1">Seminar Hall 1 (Capacity: 50)</option>
                                            <option value="seminar-2">Seminar Hall 2 (Capacity: 40)</option>
                                            <option value="physical-b">Physical Training Area B (Capacity: 15)</option>
                                            <option value="computer-lab">Computer Lab (Capacity: 30)</option>
                                            <option value="conference-a">Conference Room A (Capacity: 20)</option>
                                            <option value="outside-campus">Outside Campus</option>
                                        </select>
                                    </div>
                                    <div id="edit_outsideCampusContainer" class="hidden">
                                        <label for="edit_outsideCampusLocation" class="block text-sm font-medium text-gray-700">Outside Campus Location</label>
                                        <input type="text" name="outsideCampusLocation" id="edit_outsideCampusLocation" placeholder="Enter full address" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="edit_description" name="description" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" onclick="closeEditScheduleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle facility selection
    const facilitySelect = document.getElementById('facility');
    const outsideCampusContainer = document.getElementById('outsideCampusContainer');

    if (facilitySelect) {
        facilitySelect.addEventListener('change', function() {
            if (this.value === 'outside-campus') {
                outsideCampusContainer.classList.remove('hidden');
            } else {
                outsideCampusContainer.classList.add('hidden');
            }
        });
    }
    window.openAddScheduleModal = function() {
        document.getElementById('addScheduleModal').classList.remove('hidden');
    };

    window.closeAddScheduleModal = function() {
        document.getElementById('addScheduleModal').classList.add('hidden');
    };

    // Close modal when clicking outside
    const modal = document.getElementById('addScheduleModal');
    if (modal) {
        window.addEventListener('click', function(event) {
            if (event.target === modal.querySelector('.fixed.inset-0.transition-opacity')) {
                closeAddScheduleModal();
            }
        });
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Previous code remains here...

    // Handle facility selection for edit modal
    const editFacilitySelect = document.getElementById('edit_facility');
    const editOutsideCampusContainer = document.getElementById('edit_outsideCampusContainer');

    if (editFacilitySelect) {
        editFacilitySelect.addEventListener('change', function() {
            if (this.value === 'outside-campus') {
                editOutsideCampusContainer.classList.remove('hidden');
            } else {
                editOutsideCampusContainer.classList.add('hidden');
            }
        });
    }

    // Open and close edit modal
    window.openEditScheduleModal = function(scheduleId) {
        fetch(`/training-schedule/${scheduleId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form with data
                document.getElementById('edit_schedule_id').value = data.id;
                document.getElementById('edit_trainingTitle').value = data.training_title;
                document.getElementById('edit_trainingType').value = data.training_type;
                document.getElementById('edit_startDate').value = data.start_date;
                document.getElementById('edit_startTime').value = data.start_time;
                document.getElementById('edit_endTime').value = data.end_time;
                document.getElementById('edit_trainer').value = data.trainer;
                document.getElementById('edit_facility').value = data.facility;

                // Handle outside campus location
                if (data.facility === 'outside-campus') {
                    document.getElementById('edit_outsideCampusContainer').classList.remove('hidden');
                    document.getElementById('edit_outsideCampusLocation').value = data.outside_campus_location || '';
                } else {
                    document.getElementById('edit_outsideCampusContainer').classList.add('hidden');
                }

                document.getElementById('edit_description').value = data.description || '';

                // Set form action with correct ID
                const form = document.getElementById('editScheduleForm');
                form.action = `/training-schedule/${data.id}`;

                // Show modal
                document.getElementById('editScheduleModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching schedule data:', error);
                alert('Failed to load schedule data. Please try again.');
            });
    };

    window.closeEditScheduleModal = function() {
        document.getElementById('editScheduleModal').classList.add('hidden');
    };

    // Close edit modal when clicking outside
    const editModal = document.getElementById('editScheduleModal');
    if (editModal) {
        window.addEventListener('click', function(event) {
            if (event.target === editModal.querySelector('.fixed.inset-0.transition-opacity')) {
                closeEditScheduleModal();
            }
        });
    }
});
</script>
@endsection
