@extends('layouts.hr3-admin')

@section('title')
    Online Training Seminar Portal
@endsection
<style>
    .ring-2 {
    box-shadow: 0 0 0 2px;
}
.ring-blue-500 {
    box-shadow-color: #3b82f6;
}
</style>
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header with Title and Add Button -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Training Management System</h1>
        @if(Auth::user()->emp_acc_role == 'admin')
        <a href="{{url('training_add')}}"
            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
            <i class="fas fa-plus mr-2"></i> Add New Training
        </a>
        @endif
    </div>

    @if($seminars->count() > 0)
        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Featured Video Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden lg:col-span-3" id="primary-seminar" data-seminar-id="{{ $seminars->first()->id }}">
                <div class="relative pt-[56.25%]"> <!-- 16:9 Aspect Ratio -->
                    <video class="absolute top-0 left-0 w-full h-full object-cover seminar-video" controls id="main-video">
                        <source src="{{ asset('storage/' . $seminars->first()->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-2">Featured</div>
                        <span class="text-gray-500 text-sm" id="primary-seminar-date">{{ \Carbon\Carbon::parse($seminars->first()->date_time)->format('F j, Y h:i A') }}</span>
                    </div>
                    <h2 class="text-xl font-bold mb-2" id="primary-seminar-title">{{ $seminars->first()->title }}</h2>
                    <p class="text-gray-600 mb-4" id="primary-seminar-desc">{{ $seminars->first()->description }}</p>
                    <div class="flex items-center text-gray-500">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span id="primary-seminar-location">{{ $seminars->first()->location }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar with Other Videos -->
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <h3 class="text-lg font-semibold mb-3 border-b pb-2">Related Seminars</h3>
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        @foreach ($seminars->slice(1) as $index => $seminar)
                            <div class="bg-gray-50 rounded-lg p-3 cursor-pointer hover:bg-gray-100 transition duration-300"
                                id="seminar-{{ $seminar->id }}"
                                onclick="switchVideo('{{ asset('storage/' . $seminar->video_path) }}', '{{ $seminar->title }}', '{{ $seminar->description }}', '{{ $seminar->location }}', '{{ \Carbon\Carbon::parse($seminar->date_time)->format('F j, Y h:i A') }}', {{ $seminar->id }})">
                                <div class="relative pb-[56.25%] mb-2 rounded-lg overflow-hidden"> <!-- 16:9 Aspect Ratio -->
                                    <video class="absolute top-0 left-0 w-full h-full object-cover" preload="metadata">
                                        <source src="{{ asset('storage/' . $seminar->video_path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                        <i class="fas fa-play text-white text-2xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-medium text-gray-800 line-clamp-2">{{ $seminar->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($seminar->date_time)->format('M j, Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-lg p-10 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-video-slash text-5xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Training Videos Available</h3>
            <p class="text-gray-500">Check back later for upcoming training seminars or contact your administrator.</p>
        </div>
    @endif

    <!-- Narrative Report Section -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 p-4 border-b">
                <h2 class="text-lg font-bold text-gray-800">Seminar Reflection & Narrative Report</h2>
                <p class="text-sm text-gray-600">Please submit your narrative report after watching the seminar</p>
            </div>
            <div class="p-6">
                <form id="narrative-form" action="{{ route('reflection.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="seminar_id" value="{{ $seminars->first()->id }}" id="seminar-id-input">
                    <div>
                        <label for="narrative-comment" class="block text-sm font-medium text-gray-700 mb-2">Your Reflection</label>
                        <textarea id="narrative-comment" name="comment" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Share your thoughts and key learnings from this seminar..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Full Report (Optional)</label>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <div class="flex items-center justify-center w-full">
                                    <label for="document-upload" class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-2"></i>
                                            <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                                            <p class="text-xs text-gray-500">.pdf, .doc, .docx, .txt (Max 10MB)</p>
                                        </div>
                                        <input id="document-upload" name="document" type="file" class="hidden" accept=".pdf,.doc,.docx,.txt">
                                    </label>
                                </div>
                                <p id="file-name" class="mt-2 text-sm text-gray-500"></p>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-5 py-2.5 transition duration-300 text-center flex items-center justify-center">
                                <i class="fas fa-paper-plane mr-2"></i> Submit Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function switchVideo(videoSrc, title, description, location, dateTime, seminarId) {
        const mainVideo = document.getElementById('main-video');

        // Update video source and play
        mainVideo.pause();
        mainVideo.innerHTML = `<source src="${videoSrc}" type="video/mp4">`;
        mainVideo.load();

        // Attempt autoplay after user interaction
        mainVideo.play().catch(error => {
            console.log('Autoplay prevented, user interaction required');
        });

        // Update seminar metadata
        document.getElementById('primary-seminar-title').textContent = title;
        document.getElementById('primary-seminar-desc').textContent = description;
        document.getElementById('primary-seminar-date').textContent = dateTime;
        document.getElementById('primary-seminar-location').textContent = location;

        // Update active seminar ID
        document.getElementById('seminar-id-input').value = seminarId;
        document.getElementById('primary-seminar').dataset.seminarId = seminarId;

        // Update active state in sidebar
        document.querySelectorAll('[id^="seminar-"]').forEach(item => {
            item.classList.remove('ring-2', 'ring-blue-500');
        });
        document.getElementById(`seminar-${seminarId}`).classList.add('ring-2', 'ring-blue-500');
    }
    </script>
@endsection
