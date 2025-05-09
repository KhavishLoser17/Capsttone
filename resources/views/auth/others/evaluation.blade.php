@extends('layouts.hr3-admin')
@section('title', 'Evaluation Results')

@section('content')
<div class="px-8 py-6 bg-gray-50">
    <div class="mb-6 flex justify-end items-center">
        <div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                EXPORT RESULTS
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="p-6 bg-gray-100 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">ASSESSMENT SUMMARY</h2>
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" placeholder="SEARCH RESULTS" class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500" />
                    <div class="absolute left-3 top-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <select class="border border-gray-300 rounded-md text-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>FILTER BY STATUS</option>
                    <option>PASSED</option>
                    <option>FAILED</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PARTICIPANT</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ASSESSMENT</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SCORE</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PERCENTAGE</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STATUS</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 font-semibold">{{ substr($result->user->first_name, 0, 1) }}{{ substr($result->user->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ strtoupper($result->user->first_name) }} {{ strtoupper($result->user->last_name) }}</div>
                                    <div class="text-sm text-gray-500">{{ $result->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ strtoupper($result->exam->title) }}</div>
                            <div class="text-sm text-gray-500">PASSING SCORE: {{ $result->exam->passing_score }}%</div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $result->score }} / {{ $result->exam->questions->count() }}</div>
                            <div class="w-24 bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $result->percentage }}%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($result->percentage, 1) }}%
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $result->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $result->passed ? 'PASSED' : 'FAILED' }}
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($results->isEmpty())
        <div class="p-8 text-center">
            <div class="inline-flex rounded-full bg-gray-100 p-4 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">NO RESULTS FOUND</h3>
            <p class="mt-1 text-sm text-gray-500">There are no evaluation results matching your criteria.</p>
        </div>
        @endif

        @if($results->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $results->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Answer Details Modal -->
<div x-show="showDetails" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">EVALUATION DETAILS</h3>

                        <div class="mt-4">
                            <h4 class="text-lg font-medium text-gray-700 mb-2">PARTICIPANT RESPONSES</h4>
                            <div class="border rounded-md divide-y">
                                <!-- Example answer item -->
                                <div class="p-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="font-medium">QUESTION 1</span>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">CORRECT</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">What is the primary function of the HR department?</p>
                                    <p class="text-sm font-medium">Selected Answer: Managing human capital and ensuring compliance with labor laws</p>
                                </div>
                                <!-- Additional answers would be listed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" @click="showDetails = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    CLOSE
                </button>
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    DOWNLOAD REPORT
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Initialize Alpine.js -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('evaluationResults', () => ({
            showDetails: false
        }))
    })
</script>
@endsection
