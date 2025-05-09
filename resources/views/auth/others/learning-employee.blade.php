@extends('layouts.hr3-admin')

@section('title')
    Dashboard
@endsection

@section('content')

<div class="col-span-1 mb-2">
    <form>
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label>
        <div class="relative flex">
            <!-- Search Input -->
            <div class="flex-grow">
                <input
                    type="search"
                    id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search"
                    required
                />
                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>

            <!-- Search Button -->
            <button
                type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-r-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Search
            </button>

            <!-- ADD LMS Button -->
           
        </div>
    </form>
    <!-- Course List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($courses as $course)
            <div class="bg-white p-4 rounded-lg shadow-md">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="Course image" class="w-full h-32 object-cover rounded-md mb-4">
                @else
                    <div class="w-full h-32 bg-gray-200 rounded-md mb-4 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif
                <h3 class="text-lg font-semibold">{{ $course->title }}</h3>
                <p class="text-md text-gray-500 mb-2">{{ Str::limit($course->description, 100) }}</p>

                <div class="mb-2">
                    <p class="text-sm text-gray-600">
                        Start Date:
                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse($course->date)->format('F j, Y') }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Due Date:
                        <span class="font-semibold">
                            {{ \Carbon\Carbon::parse($course->dueDate)->format('F j, Y') }}
                        </span>
                    </p>
                </div>

                <p class="text-sm text-gray-600 mb-4">
                    Instructor:
                    <span class="font-semibold">{{ $course->instructor }}</span>
                </p>

                <a href="{{ url('content/fetch?page=' . $courses->currentPage()) }}" class="block">
                    <button class="bg-blue-500 text-white p-2 rounded-lg w-full hover:bg-blue-600 transition duration-300">
                        View Course Details
                    </button>
                </a>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-600 text-xl">No training courses available at the moment.</p>
                <p class="text-gray-500 mt-2">Check back later or contact administration.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-6 flex justify-center">
        {{ $courses->links() }}
    </div>


@endsection
