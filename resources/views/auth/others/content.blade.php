@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    
    @if(Auth::user()->emp_acc_role == 'admin')

    <div class="w-64 bg-white shadow-md p-4 flex-shrink-0">
        <h1 class="text-2xl font-bold mb-4">Name of Course</h1>

        <!-- Standard Content Section -->
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <span class="text-gray-600 text-xl">📚</span>
                <div>
                    <h3 class="font-semibold">Standard Content</h3>
                    <p class="text-sm text-gray-500">Add Text, Video, Presentation, etc.</p>
                </div>
            </div>
            <button id="showStandardContentBtn"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mt-2 w-full">
                + Add
            </button>
        </div>

        <!-- Learning Activities Section -->
        <div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 text-xl">📝</span>
                <div>
                    <h3 class="font-semibold">Learning Activities</h3>
                    <p class="text-sm text-gray-500">Add Test,Survey,Assignment,etc.</p>
                </div>
            </div>
            <button id="showLearningActivitiesBtn"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mt-2 w-full">
                + Add
            </button>

        </div>

    </div>
    @endif
    <!-- Main Content -->
    <div class="flex-1 p-6 overflow-auto bg-gray-100">
        <h2 class="text-xl font-bold">Course Overview</h2>
        <p class="text-gray-500">All units must be completed</p>

        <!-- Dynamic Content Display -->
        <div class="mt-4 space-y-4">
            <!-- Assignments -->
            @foreach($assignments as $assignment)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">{{ $assignment->title }}</h3>
                    <p class="text-gray-600">{{ $assignment->details }}</p>
                    <p class="text-gray-600">DUE-DATE: {{ \Carbon\Carbon::parse($assignment->due_date)->format('F j, Y') }}</p>

                </div>
            @endforeach

            <!-- Learning Contents -->
            @foreach($learningContents as $content)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">{{ $content->title }}</h3>
                    @if($content->image_path)
                    <img src="{{ asset('storage/' . $content->image_path) }}"
                        alt="Learning Content Image"
                        class="mt-2 w-full max-h-100 h-auto rounded-lg">
                @endif

                    <p class="text-gray-600">{{ $content->explanation }}</p>
                </div>
            @endforeach

            <!-- Web Contents -->
            @foreach($webContents as $web)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-semibold text-lg">{{ $web->title }}</h3>
                    @if(str_contains($web->url, 'docs.google.com') ||
                        str_contains($web->url, 'vimeo.com') ||
                        str_contains($web->url, 'wistia.com') ||
                        str_contains($web->url, 'wikipedia.org'))
                        <iframe class="w-full h-96 rounded-lg" src="{{ $web->url }}" frameborder="0"></iframe>
                    @else
                        <a href="{{ $web->url }}" target="_blank" class="text-blue-500 hover:underline">
                            {{ $web->url }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <!-- Surveys Section -->
        <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">


                @forelse($surveys as $survey)
                    <div class="bg-white shadow-md rounded-lg mb-4 p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-blue-700">{{ $survey->title }}</h3>
                            <span class="text-sm text-gray-500">
                                Due: {{ \Carbon\Carbon::parse($survey->due_date)->format('F j, Y') }}
                            </span>
                        </div>

                        <p class="text-gray-600 mb-4">{{ $survey->description }}</p>

                        @if($survey->questions->count() > 0)
                            <div class="border-t pt-4">
                                <h4 class="text-md font-medium text-gray-700 mb-2">Survey Questions:</h4>
                                <ul class="space-y-4">
                                    @foreach($survey->questions as $question)
                                        <li class="text-sm text-gray-600">
                                            <div class="mb-2">{{ $question->question_text }}</div>
                                            <div class="flex items-center space-x-4">
                                                <label class="emoji-label cursor-pointer p-2 rounded-lg transition-all duration-300 hover:bg-blue-50 hover:scale-110" data-value="neutral">
                                                    <input type="radio" name="response_{{ $question->id }}" value="neutral" class="hidden">
                                                    <span class="emoji text-3xl">😐</span>
                                                </label>
                                                <label class="emoji-label cursor-pointer p-2 rounded-lg transition-all duration-300 hover:bg-blue-50 hover:scale-110" data-value="happy">
                                                    <input type="radio" name="response_{{ $question->id }}" value="happy" class="hidden">
                                                    <span class="emoji text-3xl">😊</span>
                                                </label>
                                                <label class="emoji-label cursor-pointer p-2 rounded-lg transition-all duration-300 hover:bg-blue-50 hover:scale-110" data-value="angry">
                                                    <input type="radio" name="response_{{ $question->id }}" value="angry" class="hidden">
                                                    <span class="emoji text-3xl">😡</span>
                                                </label>
                                                <label class="emoji-label cursor-pointer p-2 rounded-lg transition-all duration-300 hover:bg-blue-50 hover:scale-110" data-value="sad">
                                                    <input type="radio" name="response_{{ $question->id }}" value="sad" class="hidden">
                                                    <span class="emoji text-3xl">😢</span>
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4 flex justify-between items-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                                Submit Survey
                                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <span class="text-sm text-gray-500">
                                {{ $survey->questions->count() }} Questions
                            </span>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>

        {{-- YOUTUBE AND VIDEO --}}
        <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 w-full">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($videos as $video)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                        <div class="relative w-full h-[300px] overflow-hidden flex items-center justify-center">
                            @if($video->youtube_url)
                                <iframe
                                    src="{{ $video->embed_url }}"
                                    class="absolute top-0 left-0 w-[120%] h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            @elseif($video->video_path)
                                <video
                                    controls
                                    class="absolute top-0 left-0 w-[120%] h-full object-cover"
                                >
                                    <source src="{{ Storage::url($video->video_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="absolute top-0 left-0 w-full h-full bg-gray-200 flex items-center justify-center">
                                    <p class="text-gray-500">No video available</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-red-500 uppercase tracking-wider">
                                    {{ $video->video_type ?? 'Unspecified' }}
                                </span>
                                @if($video->youtube_url)
                                    <a href="{{ $video->youtube_url }}"
                                        target="_blank"
                                        class="text-blue-500 hover:text-blue-700 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.246 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                {{ $video->title ?? 'Untitled Video' }}
                            </h3>
                            <div class="flex items-center justify-between">
                                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                                    Watch Now
                                </button>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>

        {{-- FOR QUIZ AI --}}
        <div class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 w-full">


            @forelse($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <span class="text-xl font-bold text-blue-600 mr-4">Q.</span>
                            <h3 class="text-xl font-semibold text-gray-800 flex-grow">
                                {{ $quiz->question_text }}
                            </h3>
                        </div>

                        <div class="space-y-3">
                            @foreach(json_decode($quiz->options, true) as $index => $option)
                                <div class="flex items-center">
                                    <span class="mr-3 text-gray-500 font-medium">
                                        {{ chr(65 + $index) }}.
                                    </span>
                                    <div class="flex-grow p-3 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                                        {{ $option }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t pt-4 border-gray-200">
                            <div class="flex items-center">
                                <span class="text-green-600 font-semibold mr-2">Correct Answer:</span>
                                <span class="text-gray-800 font-bold">{{ $quiz->answer }}</span>
                            </div>

                            @if($quiz->explanation)
                                <div class="mt-3 bg-blue-50 p-3 rounded-md">
                                    <span class="text-blue-800 font-medium">Explanation: </span>
                                    <p class="text-gray-700 text-sm">{{ $quiz->explanation }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
        </div>

        {{-- FOR EXAM --}}
        <div class="container mx-auto px-4 py-8">

            @foreach($exams as $exam)
                @if(!$exam->questions->isEmpty())
                <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-4">{{ $exam->title }}</h1>
                    <p class="text-gray-600 mb-6">{{ $exam->description }}</p>

                    <div class="mb-4 bg-gray-100 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold mb-2">Exam Details</h2>
                        <ul class="list-disc list-inside">
                            <li>Total Questions: {{ $exam->questions->count() }}</li>
                            <li>Time Limit: {{ $exam->time_limit }} minutes</li>
                            <li>Passing Score: {{ $exam->passing_score }}%</li>
                        </ul>
                    </div>

                    <form id="exam-start-form" method="POST" action="{{ route('exams.start', $exam->id) }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300"
                        >
                            Start Exam
                        </button>
                    </form>
                </div>
                @else
                <div class="text-center text-gray-600">
                    <p>No questions are available for this exam.</p>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination Controls -->
        <div class="mt-6 flex justify-between">
            @if ($assignments->previousPageUrl() || $learningContents->previousPageUrl() || $webContents->previousPageUrl())
                <a href="{{ request()->fullUrlWithQuery(['page' => max(1, $assignments->currentPage() - 1)]) }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    ← Previous
                </a>
            @endif

            @if ($assignments->nextPageUrl() || $learningContents->nextPageUrl() || $webContents->nextPageUrl())
                <a href="{{ request()->fullUrlWithQuery(['page' => $assignments->currentPage() + 1]) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    Next →
                </a>
            @endif
        </div>
    </div>
</div>


  <!-- Exam Modal (to be shown after start) -->
<div id="exam-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center h-full">
      <div class="bg-white rounded-lg shadow-xl w-3/4 max-h-[90%] overflow-y-auto">
        <div class="p-6">
          @foreach($exams as $exam)
          <div class="flex justify-between items-center mb-4">
            <h2 id="modal-exam-title" class="text-2xl font-bold">{{ $exam->title }}</h2>
            <div id="timer" class="text-red-500 font-semibold">
              Time Remaining: <span id="time-display">{{ $exam->time_limit }}:00</span>
            </div>
          </div>

          <form id="exam-form" method="POST" action="/exams/submit" enctype="multipart/form-data">
            @csrf
            <div id="questions-container">
              @foreach($exam->questions as $index => $question)
              <div
                class="question-slide {{ $index === 0 ? 'block' : 'hidden' }}"
                data-question-id="{{ $question->id }}"
              >
                <h3 class="text-lg font-semibold mb-4">
                  Question {{ $index + 1 }}: {{ $question->question_text }}
                </h3>

                <div class="space-y-3">
                  @php
                  $options = is_string($question->options)
                    ? explode(',', $question->options)
                    : $question->options;
                  @endphp

                  @foreach($options as $optionIndex => $option)
                  <div class="flex items-center">
                    <input
                      type="radio"
                      name="answer[{{ $question->id }}]"
                      id="option-{{ $question->id }}-{{ $optionIndex }}"
                      value="{{ $option }}"
                      class="mr-2"
                    >
                    <label
                      for="option-{{ $question->id }}-{{ $optionIndex }}"
                      class="text-gray-700"
                    >
                      {{ $option }}
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>

            <div class="flex justify-between mt-6">
              <button
                type="button"
                id="prev-question"
                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded"
              >
                Previous
              </button>

              <div>
                <span id="question-progress" class="text-gray-600">
                  Question 1 of {{ $exam->questions->count() }}
                </span>
              </div>

              <button
                type="button"
                id="next-question"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
              >
                Next
              </button>
            </div>

            <div class="mt-6 text-center">
              <button
                type="submit"
                id="submit-exam"
                class="bg-green-500 hover:bg-green-600 text-white px-8 py-2 rounded hidden"
              >
                Submit Exam
              </button>
            </div>
          </form>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- Make sure you have this in your page -->
<div id="results-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center h-full">
      <div class="bg-white rounded-lg shadow-xl w-3/4 max-h-[90%] overflow-y-auto">
        <div class="p-6">
          <h1 class="text-2xl font-bold mb-6" id="result-exam-title">Exam Results</h1>

          <div class="mb-6">
            <div class="flex items-center justify-center">
              <div class="text-center">
                <div id="result-percentage" class="text-5xl font-bold mb-2">
                  <!-- Percentage will be inserted here -->
                </div>
                <div id="result-status" class="text-xl">
                  <!-- PASSED/FAILED will be inserted here -->
                </div>
                <div class="text-gray-600 mt-2" id="result-score">
                  <!-- Score will be inserted here -->
                </div>
                <div class="text-gray-600" id="result-passing-score">
                  <!-- Passing score will be inserted here -->
                </div>
              </div>
            </div>
          </div>

          <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Question Breakdown</h2>
            <div id="result-questions">
              <!-- Question breakdown will be inserted here -->
            </div>
          </div>

          <div class="mt-8 text-center">
            <button type="button" id="close-results" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded">
              Back to Exams
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>



<!-- Standard Content Modal -->
<div id="standard-content-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Add Standard Content</h2>

        <ul class="space-y-2">
            <li>
                <button onclick="showForm('learning-content')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    📄 Content
                </button>
            </li>
            <li>
                <button onclick="showForm('web-content')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    🌐 Web content
                </button>
            </li>
            <li>
                <button onclick="showForm('video')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    🎥 Video
                </button>
            </li>
            <li>
                <button onclick="showForm('presentation')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    📊 Presentation | Document
                </button>
            </li>
        </ul>
        <button
            onclick="hideModal('standard-content-modal')"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg w-full hover:bg-red-600">
            Close
        </button>
    </div>
</div>

<!-- Learning Activities Modal -->
<div id="learning-activities-modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Add Learning Activity</h2>

        <ul class="space-y-2">
            <li>
                <button onclick="showForm('test')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    📝 Test
                </button>
            </li>
            <li>
                <button onclick="showForm('survey')" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    📊 Survey
                </button>
            </li>
            <li>
                <button onclick="document.getElementById('geminiModal').classList.remove('hidden')"
                    class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    ➕ Generate Using AI
                </button>
            </li>
            <li>
                <button onclick="showAssignmentModal()" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    ✍️ Assignment
                </button>
            </li>
            <li>
                <button onclick="showMeetModal()" class="w-full text-left p-2 hover:bg-gray-100 rounded">
                    👨‍🏫 Instructor-led training
                </button>
            </li>
        </ul>
        <button
            onclick="hideModal('learning-activities-modal')"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg w-full hover:bg-red-600">
            Close
        </button>
    </div>
</div>

<div id="geminiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
<div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
    <!-- Modal Header -->
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">GEMINI AI Question Generator</h2>
        <button
            onclick="document.getElementById('geminiModal').classList.add('hidden')"
            class="text-gray-600 hover:text-gray-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <form class="p-6 space-y-6" method="POST" action="{{route('questions.generate')}}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">Topic</label>
            <input
                type="text"
                id="topic"
                name="topic"
                placeholder="Enter question topic"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                <select
                    id="difficulty"
                    name="difficulty"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="easy">Easy</option>
                    <option value="medium" selected>Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>

            <div>
                <label for="questionType" class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                <select
                    id="questionType"
                    name="questionType"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="true-false">True/False</option>
                    <option value="short-answer">Short Answer</option>
                </select>
            </div>
        </div>

        <div>
            <label for="additionalContext" class="block text-sm font-medium text-gray-700 mb-2">Additional Context (Optional)</label>
            <textarea
                id="additionalContext"
                name="additionalContext"
                rows="3"
                placeholder="Provide any additional context for question generation"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
            <button
                type="button"
                onclick="document.getElementById('geminiModal').classList.add('hidden')"
                class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md transition-colors"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors flex items-center"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Generate
            </button>
        </div>
    </form>
</div>
</div>


<!-- Content Form Modal -->

<div id="learning-content-form" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add Content</h3>
        <form action="{{ route('content.learn') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Content Unit</label>
                    <input type="text" name="title" required
                    class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder=" Input Your Content">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Explanation</label>
                    <input type="text" name="explanation" required
                    class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Explain Your Content">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">Save</button>
                    <button type="button" onclick="hideForm('learning-content')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    </div>

<!-- Web Content Form Modal -->
<div id="web-content-form" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add Web Content</h3>
        <form action="{{ route('web-content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required
                        class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder=" Input Your Title">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">URL</label>
                    <input type="url" name="url" required
                        class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                   <span class="text-gray-500 mt-1 block w-full rounded-md">Use URLs from: Wistia, Wikipedia, Scribd, Prezi, Flickr</span>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">Publish</button>
                    <button type="button" onclick="hideForm('web-content')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    </div>

<!-- Video Form Modal -->
    <div id="video-form" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-xl p-6 w-96 shadow-xl">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Add Video</h3>
            <form action="{{ route('videos.youtube') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <!-- YouTube Video -->
                    <div class="upload-option bg-gray-100 p-4 rounded-lg cursor-pointer flex items-center gap-3 hover:bg-gray-200">
                        <input type="text" id="youtube-url" name="youtube_url" class="border p-2 rounded-md w-full" placeholder="Enter YouTube URL">
                        <button type="submit" class="Btn">
                            <span class="svgContainer">
                                <svg viewBox="0 0 576 512" fill="currentColor" height="1.6em" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"></path>
                                </svg>
                            </span>
                            <span class="BG"></span>
                        </button>
                    </div>
                    <!-- File Upload -->
                    <div class="upload-option bg-gray-100 p-4 rounded-lg cursor-pointer flex items-center gap-3 hover:bg-gray-200">
                        <input type="file" id="file-upload" name="video_file" class="hidden" onchange="showForm('file-upload')">
                        <input type="hidden" id="video-file-url" name="video_file_url" class="hidden">
                        <label for="file-upload" class="flex items-center gap-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" height="50" class="text-blue-500">
                                <path d="M16.75 19.25c0 .416-.334.75-.75.75a.748.748 0 01-.75-.75v-8.69l-2.969 2.969a.75.75 0 01-1.06-1.06l4.248-4.25a.747.747 0 011.06 0l4.252 4.25a.75.75 0 01-1.06 1.06l-2.968-2.969v8.69h-.003zm1-.25v-1.5H22c1.103 0 2 .898 2 2V22c0 1.104-.897 2-2 2H10c-1.103 0-2-.896-2-2v-2.5c0-1.102.897-2 2-2h4.25V19H10c-.275 0-.5.226-.5.5V22c0 .276.225.5.5.5h12c.275 0 .5-.224.5-.5v-2.5c0-.274-.225-.5-.5-.5h-4.25zM20 20.75a.75.75 0 111.5 0 .75.75 0 01-1.5 0z"></path>
                            </svg>
                            <span class="text-gray-700">Upload a Video</span>
                        </label>
                    </div>
                    <!-- Record a Video -->
                    <div class="upload-option bg-gray-100 p-4 rounded-lg cursor-pointer flex items-center gap-3 hover:bg-gray-200" onclick="startVideoRecording()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" height="50" class="text-green-500">
                            <path d="M17.333 10c.367 0 .667.3.667.667v10.666c0 .367-.3.667-.667.667H6.667A.669.669 0 016 21.333V10.667c0-.367.3-.667.667-.667h10.666zM6.667 8A2.67 2.67 0 004 10.667v10.666A2.67 2.67 0 006.667 24h10.666A2.67 2.67 0 0020 21.333V10.667A2.67 2.67 0 0017.333 8H6.667zM26 11.525v8.95l-4.667-2.1v2.192l4.346 1.954a1.647 1.647 0 002.32-1.5V10.979a1.647 1.647 0 00-2.32-1.5l-4.346 1.954v2.192l4.667-2.1z"></path>
                        </svg>
                        <span class="text-gray-700">Record a video</span>
                    </div>
                    <div id="preview-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Preview Recording</h2>
                                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <button id="stop-recording" class="hidden px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 mt-2">
                                    Stop Recording
                                </button>
                            </div>
                            <video id="video-preview" autoplay playsinline class="w-full rounded-lg mb-4"></video>
                            <div class="flex justify-end gap-4">
                                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                    Close
                                </button>
                                <button id="download-recording" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                    Download Recording
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Record Your Screen -->
                    <div id="recordButton" class="upload-option bg-gray-100 p-4 rounded-lg cursor-pointer flex items-center gap-3 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" height="50" class="text-purple-500">
                            <path d="M23 9.5H9c-.275 0-.5.225-.5.5v6h15v-6c0-.275-.225-.5-.5-.5zm2 6.5v3c0 1.103-.897 2-2 2h-4.616l.25 1.5h1.616c.416 0 .75.334.75.75s-.334.75-.75.75h-8.5a.748.748 0 01-.75-.75c0-.416.334-.75.75-.75h1.616l.25-1.5H9c-1.103 0-2-.897-2-2v-9c0-1.103.897-2 2-2h14c1.103 0 2 .897 2 2v6zM8.5 17.5V19c0 .275.225.5.5.5h14c.275 0 .5-.225.5-.5v-1.5h-15zm6.384 5h2.229l-.25-1.5h-1.729l-.25 1.5z"></path>
                        </svg>
                        <span class="text-gray-700">Record your screen</span>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full">Save</button>
                        <button type="button" onclick="hideForm('video')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 w-full">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


<!-- Presentation Form Modal -->
<div id="presentation-form" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Add Presentation/Document</h3>
        <form action="{{ route('presentations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required
                        class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">File</label>
                    <input type="file" name="file" accept=".pdf,.pptx,.doc,.docx" required
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">Save</button>
                    <button type="button" onclick="hideForm('presentation')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Test Form Modal -->
<div id="test-form" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Create Exam</h3>
        <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <!-- Left Column -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Time Limit (minutes)</label>
                    <input type="number" id="time-limit" name="time_limit" min="1" value="30"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Right Column -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Passing Score (%)</label>
                    <input type="number" name="passing_score" min="0" max="100" value="70" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Questions Section -->
            <div class="mt-6">
                <h4 class="text-md font-semibold">Questions</h4>
                <button type="button" onclick="addQuestion()"
                    class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 w-full">+ Add Question</button>
                <div id="question-list" class="mt-4 space-y-4"></div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-2">
                    <button type="button" id="prev-btn" onclick="prevQuestion()" class="bg-gray-500 text-white px-3 py-1 rounded-lg hidden">Previous</button>
                    <button type="button" id="next-btn" onclick="nextQuestion()" class="bg-blue-500 text-white px-3 py-1 rounded-lg hidden">Next</button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">Save</button>
                <button type="button" onclick="hideForm('test')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="assignmentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-60">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
        <h2 class="text-lg font-semibold mb-4">Assign an Assignment</h2>

        <label class="block mb-2 text-sm font-medium">Assignment Title:</label>
        <input type="text" id="assignmentTitle" class="w-full p-2 border rounded mb-4" placeholder="Enter assignment title...">

        <label class="block mb-2 text-sm font-medium">Assignment Details:</label>
        <textarea id="assignmentDetails" class="w-full p-2 border rounded mb-4" placeholder="Enter assignment details..."></textarea>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
            <input type="date" id="dueDate" name="due_date" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 mb-4">
        </div>

        <div class="flex justify-end gap-2 mt-2">
            <button onclick="hideModal('assignmentModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            <button onclick="submitAssignment()" class="px-4 py-2 bg-blue-500 text-white rounded">Publish</button>
        </div>
    </div>
</div>

<div id="meetModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-60">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
        <h2 class="text-lg font-semibold mb-4">Join Google Meet</h2>

        <label class="block mb-2 text-sm font-medium">Enter Meeting Code:</label>
        <input type="text" id="meetCode" class="w-full p-2 border rounded mb-4" placeholder="e.g., abc-defg-hij">

        <div class="flex justify-end gap-2">
            <button onclick="hideModal('meetModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            <button onclick="joinMeet()" class="px-4 py-2 bg-blue-500 text-white rounded">Join Meeting</button>
        </div>
    </div>
</div>

<!-- Survey Form Modal -->
<div id="survey-form" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-4xl shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Create Survey</h3>
        <form action="{{ route('surveys.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <!-- Questions Section -->
            <div class="mt-6">
                <h4 class="text-md font-semibold">Questions</h4>

                @for ($i = 0; $i < 5; $i++)
                <div class="p-4 bg-gray-100 rounded-lg mb-2">
                    <label class="block text-sm font-medium text-gray-700">Question {{ $i + 1 }}</label>
                    <input type="text" name="questions[]"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                    <div class="flex justify-between items-center mt-2">
                        <label class="text-gray-700">Your Response:</label>
                        <div class="flex gap-4">
                            <label>
                                <input type="radio" name="responses[{{ $i }}]" value="happy" >
                                <span class="text-2xl">😊</span>
                            </label>
                            <label>
                                <input type="radio" name="responses[{{ $i }}]" value="moderate" >
                                <span class="text-2xl">😐</span>
                            </label>
                            <label>
                                <input type="radio" name="responses[{{ $i }}]" value="angry" >
                                <span class="text-2xl">😡</span>
                            </label>
                            <label>
                                <input type="radio" name="responses[{{ $i }}]" value="sad" >
                                <span class="text-2xl">😢</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endfor

            </div>

            <!-- Buttons -->
            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">Save</button>
                <button type="button" onclick="hideForm('survey')" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">Cancel</button>
            </div>
        </form>
    </div>
    </div>



<script>
    // Function to show a modal
    function showModal(modalId) {
        document.getElementById(modalId)?.classList.remove('hidden');
    }

    // Function to hide a modal
    function hideModal(modalId) {
        document.getElementById(modalId)?.classList.add('hidden');
    }

    // Event listeners for buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('showStandardContentBtn')?.addEventListener('click', () => showModal('standard-content-modal'));
        document.getElementById('showLearningActivitiesBtn')?.addEventListener('click', () => showModal('learning-activities-modal'));
    });

    // Function to show specific forms
    function showForm(type) {
        const form = document.getElementById(type + '-form');
        if (form) {
            form.classList.remove('hidden');
        }
    }

    // Function to hide specific forms
    function hideForm(type) {
        const form = document.getElementById(type + '-form');
        if (form) {
            form.classList.add('hidden');
        }
    }

    // Assignment Modal Functions
    function showAssignmentModal() {
        hideModal('learning-activities-modal');
        showModal('assignmentModal');
    }

    function closeAssignmentModal() {
        hideModal('assignmentModal');
    }

    function submitAssignment() {
        const title = document.getElementById('assignmentTitle')?.value;
        const details = document.getElementById('assignmentDetails')?.value;

        if (title && details) {
            console.log('Assignment submitted:', { title, details });
            closeAssignmentModal();
        } else {
            alert('Please fill in both title and details');
        }
    }

    // Meet Modal Functions
    function showMeetModal() {
        hideModal('learning-activities-modal');
        showModal('meetModal');
    }

    function closeMeetModal() {
        hideModal('meetModal');
    }

    function joinMeet() {
        const meetCode = document.getElementById('meetCode')?.value;

        if (meetCode) {
            console.log('Joining meet with code:', meetCode);
            closeMeetModal();
        } else {
            alert('Please enter a meeting code');
        }
    }

    // Close the modal when clicking outside of it
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('video-form');
        if (modal && event.target === modal) {
            hideForm('video');
        }
    });
</script>
<script>
    // Function to show the modal
    function showForm(id) {
        const modal = document.getElementById(id + '-form');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    // Function to hide the modal
    function hideForm(id) {
        const modal = document.getElementById(id + '-form');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Close modal when clicking outside the modal content
    document.addEventListener('click', function (event) {
        const modal = document.getElementById('presentation-form');
        if (modal && event.target === modal) {
            hideForm('presentation');
        }
    });

    // Close modal when pressing the Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            hideForm('presentation');
        }
    });
</script>

    <script>
    let mediaRecorder = null;
    let recordedChunks = [];
    let stream = null;
    let recordedVideoUrl = null;

    function showStatus(message, isError = false) {
        const statusElement = document.getElementById('status-message');
        statusElement.textContent = message;
        statusElement.classList.remove('hidden');
        statusElement.classList.toggle('text-red-500', isError);
        statusElement.classList.toggle('text-green-500', !isError);
    }

        function startVideoRecording() {
        recordedChunks = [];

        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(videoStream => {
                console.log("Camera Accessed: ", videoStream);
                stream = videoStream;

                // Ensure video preview exists
                const videoPreview = document.getElementById('video-preview');
                if (!videoPreview) {
                    console.error("Video preview element not found!");
                    return;
                }

                videoPreview.srcObject = stream;
                videoPreview.play();

                // Show the modal
                openModal();

                try {
                    mediaRecorder = new MediaRecorder(stream, { mimeType: 'video/webm;codecs=vp9,opus' });
                } catch (e) {
                    mediaRecorder = new MediaRecorder(stream);
                }

                mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) {
                        recordedChunks.push(event.data);
                    }
                };

                mediaRecorder.onstart = () => {
                    showStatus('Recording started');
                    document.getElementById('stop-recording').classList.remove('hidden');
                };

                mediaRecorder.start(1000);

                document.getElementById('stop-recording').onclick = stopRecording;
            })
            .catch(err => {
                console.error("Error accessing camera:", err);
                alert("Error accessing camera: " + err.message);
            });
    }


    function stopRecording() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') return;

        mediaRecorder.stop();

        mediaRecorder.onstop = () => {
            const stopButton = document.getElementById('stop-recording');
            const modalVideo = document.getElementById('modal-video-preview');

            // Stop all tracks
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Create the final video blob
            const blob = new Blob(recordedChunks, { type: 'video/webm' });
            recordedVideoUrl = URL.createObjectURL(blob);

            // Set the video source in the modal
            modalVideo.src = recordedVideoUrl;

            // Update UI
            stopButton.classList.add('hidden');
            showStatus('Recording stopped');

            // Show modal
            openModal();

            // Setup download button
            document.getElementById('download-recording').onclick = () => {
                const a = document.createElement('a');
                a.href = recordedVideoUrl;
                a.download = 'recorded-video.webm';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };
        };
    }

    function openModal() {
    const modal = document.getElementById('preview-modal');
    if (!modal) {
        console.error("Modal not found!");
        return;
    }
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        const modal = document.getElementById('preview-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';

        // Stop video stream
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        // Reset the preview video
        const videoPreview = document.getElementById('video-preview');
        videoPreview.srcObject = null;
        videoPreview.src = '';

        // Clean up the recorded video URL
        if (recordedVideoUrl) {
            URL.revokeObjectURL(recordedVideoUrl);
            recordedVideoUrl = null;
        }
    }


    // Close modal when clicking outside
    document.getElementById('preview-modal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('preview-modal')) {
            closeModal();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    </script>

{{-- SCRIPT FOR RECORD SCREEN --}}

<script>

    document.addEventListener('DOMContentLoaded', function() {
        let mediaRecorder;
        let recordedChunks = [];


        const recordButton = document.getElementById('recordButton');

        // Add click event listener to the button
        recordButton.addEventListener('click', startScreenRecording);

        async function startScreenRecording() {
            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({
                    video: { mediaSource: "screen" },
                    audio: true
                });

                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) {
                        recordedChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = saveRecording;
                mediaRecorder.start();


                const tracks = stream.getTracks();
                tracks.forEach(track => {
                    track.onended = () => {
                        stopScreenRecording();
                    };
                });
            } catch (err) {
                console.error("Error starting screen recording:", err);
            }
        }

        function stopScreenRecording() {
            if (mediaRecorder && mediaRecorder.state !== "inactive") {
                mediaRecorder.stop();
            }
        }

        function saveRecording() {
            const blob = new Blob(recordedChunks, { type: "video/webm" });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "screen-recording.webm";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            recordedChunks = [];
        }
    });
</script>

<script>
    let questionCount = 0;
    let currentQuestionIndex = 0;
    const questions = [];

    // Function to show the modal
    function showForm(id) {
        const modal = document.getElementById(id + '-form');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    // Function to hide the modal
    function hideForm(id) {
        const modal = document.getElementById(id + '-form');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Function to add a question
    function addQuestion() {
        questionCount++;
        const questionDiv = document.createElement("div");
        questionDiv.classList.add("question", "p-3", "border", "rounded-md");
        questionDiv.setAttribute("data-index", questionCount - 1);
        questionDiv.innerHTML = `
            <label class="block text-sm font-medium text-gray-700">Question ${questionCount}</label>
            <input type="text" name="questions[]" required placeholder="Enter your question text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700">Answer Options</label>
                <p class="text-xs text-gray-500 mb-2">Enter comma-separated options. These will be formatted as A, B, C, D automatically.</p>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <div class="flex items-center">
                            <span class="mr-2 font-bold text-gray-700">A.</span>
                            <input type="text" name="option_a_${questionCount}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 option-input"
                                placeholder="Option A" onchange="updateOptions(${questionCount})">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <span class="mr-2 font-bold text-gray-700">B.</span>
                            <input type="text" name="option_b_${questionCount}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 option-input"
                                placeholder="Option B" onchange="updateOptions(${questionCount})">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <span class="mr-2 font-bold text-gray-700">C.</span>
                            <input type="text" name="option_c_${questionCount}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 option-input"
                                placeholder="Option C" onchange="updateOptions(${questionCount})">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center">
                            <span class="mr-2 font-bold text-gray-700">D.</span>
                            <input type="text" name="option_d_${questionCount}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 option-input"
                                placeholder="Option D" onchange="updateOptions(${questionCount})">
                        </div>
                    </div>
                </div>

                <!-- Hidden field to store combined options -->
                <input type="hidden" name="options[]" id="options_${questionCount}">
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                <p class="text-xs text-gray-500 mb-2">Select the correct answer from the options</p>
                <select name="correct_answers[]" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    id="correct_answer_${questionCount}">
                    <option value="">Select correct answer</option>
                </select>
            </div>
        `;

        document.getElementById("question-list").appendChild(questionDiv);
        questions.push(questionDiv);

        updateQuestionVisibility();
        updateButtons();
    }

    function updateOptions(questionNum) {
        const optionA = document.querySelector(`[name="option_a_${questionNum}"]`).value.trim();
        const optionB = document.querySelector(`[name="option_b_${questionNum}"]`).value.trim();
        const optionC = document.querySelector(`[name="option_c_${questionNum}"]`).value.trim();
        const optionD = document.querySelector(`[name="option_d_${questionNum}"]`).value.trim();

        // Update hidden options field
        const options = [optionA, optionB, optionC, optionD].filter(opt => opt !== '').join(',');
        document.getElementById(`options_${questionNum}`).value = options;

        // Update correct answer dropdown
        const correctAnswerSelect = document.getElementById(`correct_answer_${questionNum}`);
        correctAnswerSelect.innerHTML = '<option value="">Select correct answer</option>';

        if (optionA) {
            correctAnswerSelect.innerHTML += `<option value="${optionA}">${optionA}</option>`;
        }
        if (optionB) {
            correctAnswerSelect.innerHTML += `<option value="${optionB}">${optionB}</option>`;
        }
        if (optionC) {
            correctAnswerSelect.innerHTML += `<option value="${optionC}">${optionC}</option>`;
        }
        if (optionD) {
            correctAnswerSelect.innerHTML += `<option value="${optionD}">${optionD}</option>`;
        }
    }

    function updateQuestionVisibility() {
        questions.forEach((q, index) => {
            q.style.display = (index >= currentQuestionIndex && index < currentQuestionIndex + 2) ? "block" : "none";
        });
    }

    function nextQuestion() {
        if (currentQuestionIndex + 2 < questions.length) {
            currentQuestionIndex += 2;
            updateQuestionVisibility();
            updateButtons();
        }
    }

    function prevQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex -= 2;
            updateQuestionVisibility();
            updateButtons();
        }
    }

    // Function to update the visibility of navigation buttons
    function updateButtons() {
        document.getElementById("prev-btn").style.display = currentQuestionIndex > 0 ? "block" : "none";
        document.getElementById("next-btn").style.display = currentQuestionIndex + 2 < questions.length ? "block" : "none";
    }

    // Close modal when clicking outside
    document.addEventListener('click', function (event) {
        const modal = document.getElementById('test-form');
        if (modal && event.target === modal) {
            hideForm('test');
        }
    });

    // Close modal when pressing the Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            hideForm('test');
        }
    });
</script>

<!-- JavaScript for Modal -->
<script>
function showAssignmentModal() {
    document.getElementById('assignmentModal').classList.remove('hidden');
}

function closeAssignmentModal() {
    document.getElementById('assignmentModal').classList.add('hidden');
}

function submitAssignment() {
    const student = document.getElementById('studentSelect').value;
    const details = document.getElementById('assignmentDetails').value;

    if (!details.trim()) {
        alert('Please enter assignment details.');
        return;
    }

    console.log(`Assignment assigned to: ${student}\nDetails: ${details}`);
    alert('Assignment assigned successfully!');

    closeAssignmentModal();
}
</script>
<script>
function showMeetModal() {
    document.getElementById('meetModal').classList.remove('hidden');
}

function closeMeetModal() {
    document.getElementById('meetModal').classList.add('hidden');
}

function joinMeet() {
    const code = document.getElementById('meetCode').value.trim();

    if (!code) {
        alert('Please enter a meeting code.');
        return;
    }

    const meetUrl = `https://meet.google.com/${code}`;
    window.open(meetUrl, '_blank'); // Open in a new tab

    closeMeetModal();
}
</script>

<script>
    function submitAssignment() {
        let title = document.getElementById('assignmentTitle').value;
        let details = document.getElementById('assignmentDetails').value;
        let dueDate = document.getElementById('dueDate').value;

        fetch("{{ route('assignments.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                title: title,
                details: details,
                due_date: dueDate
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            hideModal('assignmentModal');
        })
        .catch(error => console.error("Error:", error));
    }
    </script>

    <script>
      function generateAndStoreQuestion() {
    axios.post('/generate-and-store-question', {
        topic: document.getElementById('topic').value,
        difficulty: document.getElementById('difficulty').value,
        questionType: document.getElementById('questionType').value,
        additionalContext: document.getElementById('additionalContext').value
    })
    .then(response => {
        console.log('Question generated and stored:', response.data.question);
        // Optionally update UI or show success message
    })
    .catch(error => {
        console.error('Error generating and storing question:', error);
        // Handle error, show error message
    });
}
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emojiLabels = document.querySelectorAll('.emoji-label');

            emojiLabels.forEach(label => {
                label.addEventListener('click', function() {
                    // Remove selected class from all labels in the same question
                    const siblingLabels = this.closest('li').querySelectorAll('.emoji-label');
                    siblingLabels.forEach(sibling => {
                        sibling.classList.remove('bg-blue-100', 'shadow-md', 'scale-110');
                    });

                    // Add selected class to clicked label
                    this.classList.add('bg-blue-100', 'shadow-md', 'scale-110');

                    // Ensure the radio button is checked
                    const radioInput = this.querySelector('input[type="radio"]');
                    if (radioInput) {
                        radioInput.checked = true;
                    }
                });
            });
        });
        </script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const examStartForm = document.getElementById('exam-start-form');
    const examModal = document.getElementById('exam-modal');
    const resultsModal = document.getElementById('results-modal');
    const questionsContainer = document.getElementById('questions-container');
    const prevButton = document.getElementById('prev-question');
    const nextButton = document.getElementById('next-question');
    const submitButton = document.getElementById('submit-exam');
    const questionProgress = document.getElementById('question-progress');
    const timeDisplay = document.getElementById('time-display');
    const examForm = document.getElementById('exam-form');
    const closeResultsButton = document.getElementById('close-results');

    // Variables to track current state
    let currentQuestionIndex = 0;
    let questionSlides = [];
    let timer;
    let timeRemaining;
    let examId;

    // Handle exam start
    if (examStartForm) {
        examStartForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get the exam ID from the form action or data attribute
            examId = this.dataset.examId || this.getAttribute('action').split('/').pop();

            // Start the exam via AJAX to create the session
            startExamSession(examId).then(success => {
                if (success) {
                    // Show the exam modal
                    examModal.classList.remove('hidden');

                    // Initialize exam
                    initExam();
                }
            });
        });
    }

    // Function to start the exam session
    function startExamSession(examId) {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                          document.querySelector('input[name="_token"]')?.value;

        if (!csrfToken) {
            console.error('CSRF token not found');
            alert('CSRF token not found. Please refresh the page and try again.');
            return Promise.resolve(false);
        }

        // Show loading indicator
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingOverlay.innerHTML = `
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <p class="text-lg font-semibold">Starting Exam...</p>
                <p>Please wait while we prepare your exam.</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        // Make AJAX request to start exam
        return fetch(`/exams/start/${examId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                _token: csrfToken
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.error || `Server error: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            // Remove loading overlay
            document.body.removeChild(loadingOverlay);

            // If there's an error, show it
            if (data.error) {
                alert(data.error);
                return false;
            }

            // Store any returned data if needed
            return true;
        })
        .catch(error => {
            // Remove loading overlay
            if (document.body.contains(loadingOverlay)) {
                document.body.removeChild(loadingOverlay);
            }

            console.error('Error starting exam:', error);
            alert(error.message || 'There was an error starting the exam. Please try again.');
            return false;
        });
    }

    // Initialize exam functionality
    function initExam() {
        // Get all question slides
        questionSlides = document.querySelectorAll('.question-slide');

        // Set up initial display
        updateQuestionDisplay();

        // Initialize timer if available
        if (timeDisplay) {
            const timeParts = timeDisplay.textContent.split(':');
            timeRemaining = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
            startTimer();
        }
    }

    // Navigation buttons
    if (prevButton) {
        prevButton.addEventListener('click', function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                updateQuestionDisplay();
            }
        });
    }

    if (nextButton) {
        nextButton.addEventListener('click', function() {
            if (currentQuestionIndex < questionSlides.length - 1) {
                currentQuestionIndex++;
                updateQuestionDisplay();
            } else {
                // If we're on the last question and Next button says "Submit Exam"
                if (nextButton.textContent.trim() === 'Submit Exam') {
                    submitExam();
                }
            }
        });
    }

    // Submit button (separate from Next button on last slide)
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            submitExam();
        });
    }

    // Form submission
    if (examForm) {
        examForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitExam();
        });
    }

    // Close results button
    if (closeResultsButton) {
        closeResultsButton.addEventListener('click', function() {
            resultsModal.classList.add('hidden');
            // Modified to prevent redirection error - use a more generic approach
            window.location.href = window.location.pathname; // Refresh the current page
        });
    }

    // Function to update question display
    function updateQuestionDisplay() {
        // Hide all slides
        questionSlides.forEach((slide, index) => {
            slide.classList.toggle('hidden', index !== currentQuestionIndex);
        });

        // Update Previous button state
        if (prevButton) {
            prevButton.disabled = currentQuestionIndex === 0;
            // Add visual disabled state
            if (currentQuestionIndex === 0) {
                prevButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                prevButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Update Next button text
        if (nextButton) {
            if (currentQuestionIndex === questionSlides.length - 1) {
                nextButton.textContent = 'Submit Exam';
                nextButton.classList.add('bg-green-500', 'hover:bg-green-600');
                nextButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            } else {
                nextButton.textContent = 'Next';
                nextButton.classList.add('bg-blue-500', 'hover:bg-blue-600');
                nextButton.classList.remove('bg-green-500', 'hover:bg-green-600');
            }
        }

        // Update question progress indicator
        if (questionProgress && questionSlides.length > 0) {
            questionProgress.textContent = `Question ${currentQuestionIndex + 1} of ${questionSlides.length}`;
        }

        // Show/hide submit button based on position - using the dedicated submit button is optional
        if (submitButton) {
            submitButton.classList.toggle('hidden', currentQuestionIndex !== questionSlides.length - 1);
        }
    }

    // Timer functionality
    function startTimer() {
        timer = setInterval(function() {
            timeRemaining--;

            if (timeRemaining <= 0) {
                clearInterval(timer);
                // Auto-submit the form when time expires
                submitExam();
                return;
            }

            // Update the timer display
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            timeDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            // Add warning class when time is running low (less than a minute)
            if (timeRemaining < 60) {
                timeDisplay.classList.add('text-red-600', 'font-bold');
            }
        }, 1000);
    }

    // Function to submit exam
    function submitExam() {
        // Disable submit buttons to prevent multiple submissions
        if (submitButton) submitButton.disabled = true;
        if (nextButton) nextButton.disabled = true;

        // Clear timer if it's running
        if (timer) {
            clearInterval(timer);
        }

        // Show loading indicator
        let loadingOverlay;
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Submitting Exam',
                text: 'Please wait while your answers are being processed...',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false
            });
        } else {
            loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            loadingOverlay.innerHTML = `
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <p class="text-lg font-semibold">Submitting Exam...</p>
                    <p>Please wait while your answers are being processed.</p>
                </div>
            `;
            document.body.appendChild(loadingOverlay);
        }

        // Collect all answers
        const answers = {};
        document.querySelectorAll('.question-slide').forEach(slide => {
            const questionId = slide.dataset.questionId;
            const selectedOption = slide.querySelector('input[type="radio"]:checked');
            answers[questionId] = selectedOption ? selectedOption.value : null;
        });

        // Get CSRF token from meta tag or form input
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) csrfToken = tokenInput.value;
        }

        if (!csrfToken) {
            console.error('CSRF token not found');
            // Handle error and show message
            showSubmissionError('CSRF token not found. Please refresh the page and try again.');
            return;
        }

        // Submit the data via AJAX
        fetch('/exams/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                answer: answers,
                _token: csrfToken
            })
        })
        .then(response => {
            // Check for response status
            if (!response.ok) {
                return response.json().then(errData => {
                    throw new Error(errData.error || `Server error: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            // Close the loading indicator
            if (typeof Swal !== 'undefined') {
                Swal.close();
            } else if (loadingOverlay) {
                document.body.removeChild(loadingOverlay);
            }

            // Hide exam modal
            examModal.classList.add('hidden');

            // Display results
            displayResults(data);
        })
        .catch(error => {
            console.error('Error:', error);
            showSubmissionError(error.message || 'There was an error submitting your exam. Please try again.');
        });
    }

    // Helper function to show submission errors
    function showSubmissionError(message) {
        // Close any loading indicators
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else if (document.querySelector('.fixed.inset-0.bg-black.bg-opacity-50')) {
            document.body.removeChild(document.querySelector('.fixed.inset-0.bg-black.bg-opacity-50'));
            alert(message);
        } else {
            alert(message);
        }

        // Re-enable the submit buttons
        if (submitButton) {
            submitButton.disabled = false;
        }
        if (nextButton) {
            nextButton.disabled = false;
        }
    }

    // Function to display results
    function displayResults(data) {
    // Set exam title
    document.getElementById('result-exam-title').textContent = data.exam.title + ' - Results';

    // Set result percentage with appropriate color
    const resultPercentage = document.getElementById('result-percentage');
    resultPercentage.textContent = data.result.percentage.toFixed(1) + '%';

    // Apply appropriate color class for pass/fail
    resultPercentage.className = 'text-5xl font-bold mb-2';
    if (data.result.passed) {
        resultPercentage.classList.add('text-green-500');
    } else {
        resultPercentage.classList.add('text-red-500');
    }

    // Set pass/fail status
    document.getElementById('result-status').textContent = data.result.passed ? 'PASSED' : 'FAILED';
    document.getElementById('result-status').className = 'text-xl ' +
        (data.result.passed ? 'text-green-600' : 'text-red-600');

    // Set score
    const totalQuestions = Object.keys(data.result.answers).length;
    document.getElementById('result-score').textContent = `Score: ${data.result.score} / ${totalQuestions}`;

    // Set passing score
    document.getElementById('result-passing-score').textContent = `Passing score: ${data.exam.passing_score}%`;

    // Generate question breakdown
    const questionsContainer = document.getElementById('result-questions');
    questionsContainer.innerHTML = ''; // Clear previous content

    // Create answers breakdown
    for (const questionId in data.result.answers) {
        const answer = data.result.answers[questionId];
        const questionDiv = document.createElement('div');
        questionDiv.className = 'border-b border-gray-200 py-4';

        // Question text
        const questionText = document.createElement('div');
        questionText.className = 'mb-2 font-medium';
        questionText.textContent = answer.question_text;
        questionDiv.appendChild(questionText);

        // User answer
        const userAnswerDiv = document.createElement('div');
        userAnswerDiv.className = 'flex items-center mb-1';

        const userAnswerLabel = document.createElement('span');
        userAnswerLabel.className = 'font-medium mr-2';
        userAnswerLabel.textContent = 'Your answer:';
        userAnswerDiv.appendChild(userAnswerLabel);

        const userAnswerValue = document.createElement('span');
        userAnswerValue.className = answer.is_correct ? 'text-green-500' : 'text-red-500';
        userAnswerValue.textContent = answer.user_answer || 'No answer provided';
        userAnswerDiv.appendChild(userAnswerValue);

        questionDiv.appendChild(userAnswerDiv);

        // Show correct answer if user was wrong
        if (!answer.is_correct) {
            const correctAnswerDiv = document.createElement('div');
            correctAnswerDiv.className = 'flex items-center text-green-600';

            const correctAnswerLabel = document.createElement('span');
            correctAnswerLabel.className = 'font-medium mr-2';
            correctAnswerLabel.textContent = 'Correct answer:';
            correctAnswerDiv.appendChild(correctAnswerLabel);

            const correctAnswerValue = document.createElement('span');
            correctAnswerValue.textContent = answer.correct_answer;
            correctAnswerDiv.appendChild(correctAnswerValue);

            questionDiv.appendChild(correctAnswerDiv);
        }

        questionsContainer.appendChild(questionDiv);
    }

    // Show results modal
    document.getElementById('results-modal').classList.remove('hidden');
}

    // If exam modal is already visible on page load, initialize the exam
    if (examModal && !examModal.classList.contains('hidden')) {
        initExam();
    }
});
</script>



@endsection
