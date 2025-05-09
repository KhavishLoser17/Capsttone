@extends('layouts.hr3-client')

@section('content')
<style>
    body {
        @apply bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50;
    }
</style>

<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-96 transition-all duration-300 hover:shadow-2xl">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('img/jvdlogo.png') }}" alt="JVD Logo" class="w-auto h-20">
            </div>
        </div>

        <form method="POST" action="{{ route('two-factor.verify' )}}" class="space-y-6">
            @csrf

            @if(session('success'))
                <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
                <input type="text" name="code" id="code"
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="Enter 6-digit code" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-all duration-300 font-semibold shadow-md hover:shadow-lg">
                Verify Code
            </button>
        </form>

        <form method="POST" action="" class="mt-6 text-center">
            @csrf
            <button type="submit"
                class="text-purple-600 hover:text-purple-800 text-sm font-medium transition-colors duration-200 underline underline-offset-4">
                Didn't receive a code? Resend
            </button>
        </form>

        @if ($errors->any())
        <div class="mt-6 p-4 bg-red-50 text-red-700 rounded-lg text-sm">
            @foreach ($errors->all() as $error)
            <p class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $error }}
            </p>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
