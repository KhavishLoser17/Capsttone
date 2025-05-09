<div class="flex flex-row justify-between">
  <nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
      @foreach($breadcrumbs as $index => $breadcrumb)
        <li class="inline-flex items-center">
          <!-- Check if it's the first breadcrumb -->
          @if ($index == 0)
            <!-- Check if the first breadcrumb is not dashboard -->
            @if ($breadcrumb['url'] !== 'dashboard')
              <!-- Insert Dashboard breadcrumb -->
              <a href="{{ url('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg> 
                Dashboard 
              </a>
              <!-- Separator -->
              <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>
            @endif
            <!-- Actual breadcrumb -->
            <a href="{{ url($breadcrumb['url']) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
               {{ $breadcrumb['name'] }} 
            </a>
          @elseif ($index === count($breadcrumbs) - 1)
            <!-- Last breadcrumb (not clickable) -->
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $breadcrumb['name'] }}</span>
          @else
            <!-- Middle breadcrumbs -->
            <div class="flex items-center">
              <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
              </svg>
              <a href="{{ url($breadcrumb['url']) }}" class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $breadcrumb['name'] }}</a>
            </div>
          @endif
          
          <!-- Add a separator after each breadcrumb except the last one -->
          @if ($index !== count($breadcrumbs) - 1)
            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
          @endif
        </li>
      @endforeach
    </ol>
  </nav>

  <!-- Digital Clock Section -->
  <div id="clock" class="text-sm font-medium text-gray-500 dark:text-gray-400"></div>
</div>



<script>
  function updateClock() {
    const clockElement = document.getElementById("clock");
    const now = new Date();

    let hours = now.getHours();
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const ampm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; 

    // Format time as HH:MM:SS AM/PM
    clockElement.textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
  }

  updateClock();
  setInterval(updateClock, 1000);
</script>
