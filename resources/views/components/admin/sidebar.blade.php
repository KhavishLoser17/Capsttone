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

        @if(Auth::user()->emp_acc_role == 'admin')
        <!-- Admin-only menus -->
        <a href="{{ route('competency') }}" class="p-4 hover:bg-gray-200 {{ Route::is('attendance') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/attendance-mark.png" alt="attendance-mark"/>
                    <span>Competency</span>
                </div>
            </div>
        </a>

        <a href="{{ route('succession') }}" class="p-4 hover:bg-gray-200 {{ Route::is('timesheet') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/property-time.png" alt="property-time"/>
                    <span>Succession Planning</span>
                </div>
            </div>
        </a>

        <a href="{{ route('competent') }}" class="p-4 hover:bg-gray-200 {{ Route::is('timesheet') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/task.png" alt="employee-evaluation"/>
                    <span>Employee Evaluation Monitoring</span>
                </div>
            </div>
        </a>
        @endif
        <a href="{{route('learning')}}" class="p-4 hover:bg-gray-200 {{ Route::is('schedule') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios/50/overtime--v1.png" alt="overtime--v1"/>
                    <span>Learning Management</span>
                </div>
                @if(Auth::user()->emp_acc_role == 'employee')
                <span id="notificationBadge" class="bg-red-600 text-white rounded-full px-2 hidden">1</span>
                @endif
            </div>
        </a>
        <div class="w-full">
            @php
                $trainingActive = Route::is('auth.others.seminar') || Route::is('auth.others.schedule');
            @endphp
            <button id="trainingDropdownBtn"
                    class="w-full p-4 text-left hover:bg-gray-200 flex items-center justify-between {{ $trainingActive ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="httpsd://img.icons8.com/dotty/80/payroll.png" alt="payroll"/>
                    <span>Training Management</span>
                </div>

                <svg class="w-4 h-4 ml-2 transition-transform duration-200" id="dropdownArrow" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div id="trainingDropdownMenu"
                 class="transition-all duration-300 ease-in-out overflow-hidden max-h-0">
                <a href="{{route('training')}}"
                   class="block px-8 py-2 text-sm text-gray-700 hover:bg-gray-100">Online Seminar</a>

                <a href="{{ route('auth.others.seminar') }}"
                   class="block px-8 py-2 text-sm text-gray-700 hover:bg-gray-100">Training Schedule</a>
            </div>

        </div>
        @if(Auth::user()->emp_acc_role == 'admin')
        <!-- Admin-only archive menu -->
        <a href="{{route('auth.others.archive')}}" class="p-4 hover:bg-gray-200 {{ Route::is('payroll') ? 'bg-gray-200 shadow-inner shadow-gray-400 rounded-l-full' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img class="size-5" src="https://img.icons8.com/ios-filled/50/money.png" alt="payroll"/>
                    <span>Archive</span>
                </div>
            </div>
        </a>
        @endif
    </ul>
</div>

<div class="px-4 py-2 border-t border-gray-100">
    <p class="text-gray-500 text-[12px]">Logged in as:</p>
    <h1 class="text-black-500 text-sm font-semibold">
        {{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}
    </h1>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('trainingDropdownBtn');
        const menu = document.getElementById('trainingDropdownMenu');
        const arrow = document.getElementById('dropdownArrow');

        let open = false;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            open = !open;

            if (open) {
                menu.classList.remove('max-h-0');
                menu.classList.add('max-h-40'); // adjust based on content height
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.remove('max-h-40');
                menu.classList.add('max-h-0');
                arrow.classList.remove('rotate-180');
            }
        });

        // Optional: click outside to close
        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('max-h-40');
                menu.classList.add('max-h-0');
                arrow.classList.remove('rotate-180');
                open = false;
            }
        });
    });
</script>
