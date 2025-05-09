<div class="flex flex-col h-screen overflow-auto scrollbar pl-1">
    <div class="w-full justify-center items-center flex p-4 mt-2 border-b-2 border-gray-100">
        <img class="w-full px-10" src="{{ asset('img/jvdlogo.png') }}" alt="">
    </div>
    <ul class="w-full flex-grow text-sm gap-1 flex flex-col">
        <!-- Dashboard -->
        <a href="{{ Route('dashboard')}}" class="p-4 hover:bg-gray-200 {{ Route::is('dashboard') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/control-panel--v2.png" alt="control-panel--v2"/>
                    <span>Dashboard</span>
                </div>
                {{-- <span id="notificationBadge" class="bg-red-600 text-white rounded-full px-2 hidden">1</span> --}}
            </div>
        </a>
{{--

        <li class="p-4 hover:bg-gray-200 {{ Route::is('attendance-management') || Route::is('timesheet-list') || Route::is('schedules') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <a id="toggleAttendanceSubmenu" class="flex items-center justify-between cursor-pointer gap-2">
                <div class="flex items-center gap-2 w-full">
                    <img class="size-5" src="https://img.icons8.com/ios/50/attendance-mark.png" alt="attendance-mark"/>
                    <div class="flex items-center justify-between w-full">
                        <span>Time and Attendance</span>
                        <i class="fa-solid fa-chevron-down ml-auto"></i>
                    </div>
                </div>
                <span id="notificationBadge" class="bg-red-600 text-white rounded-full px-2 hidden">1</span>
            </a>
            <ul id="attendanceSubmenu" class="ml-8 mt-2 hidden">
                <li class="p-2 hover:bg-gray-200"><a href="/attendance-management">Attendance & Overtime</a></li>
                <li class="p-2 hover:bg-gray-200"><a href="/timesheet-list">Timesheet Management</a></li>
                <li class="p-2 hover:bg-gray-200"><a href="/schedules">Schedules Management</a></li>
            </ul>
        </li> --}}





        <a href="{{route('learning-employee')}}" class="p-4 hover:bg-gray-200 {{ Route::is('schedule') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/overtime--v1.png" alt="overtime--v1"/>
                    <span>Learning Management</span>
                </div>
                {{-- <span id="notificationBadge" class="bg-red-600 text-white rounded-full px-2 hidden">1</span> --}}
            </div>
        </a>


        <a href="{{route('training')}}" class="p-4 hover:bg-gray-200 {{ Route::is('payroll') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/dotty/80/payroll.png" alt="payroll"/>
                    <span>Training Management</span>
                </div>
                {{-- <span id="notificationBadge" class="bg-red-600 text-white rounded-full px-2 hidden">1</span> --}}
            </div>
        </a>
    </ul>
</div>

{{-- <div class="px-4 py-2 border-t border-gray-100">
    <p class="text-gray-500 text-[12px]">Logged in as:</p>
    <h1 class="text-gray-500 text-sm font-semibold">
        {{ Auth::user()->employees->firstname ?? '' }} {{ Auth::user()->employees->lastname ?? '' }}
    </h1>
</div> --}}
