@extends('layouts.hr3-client')

@section('title')
    Login
@endsection

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 flex-1 flex items-center justify-around md:p-8">
    <div class="flex items-center justify-center hidden md:flex">
        <img class="w-3/4 p-10" src="{{ asset('img/login-background.png') }}" alt="">
    </div>
    <div class="flex items-center justify-center">
        <div class="w-[400px] rounded-lg bg-white p-8 shadow-lg flex flex-col gap-2">
            <div>
                <h1 class="text-2xl font-medium uppercase">Sign In</h1>
                <p class="text-gray-500 font-light">Please log in to access your account.</p>
            </div>
            {{-- @if ($errors->any())
                <div class="bg-red-50 text-red-500 p-2 rounded-md">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif --}}
            <form action="{{ route('loginPost') }}" method="POST">
                @csrf
                <div class="py-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                          </svg>
                        </span>
                        <input type="email" id="email" name="email" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="jvd@gmail.com">
                    </div>
                </div>
                <div class="py-2">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                          </svg>
                        </span>
                        <input type="password" id="password" name="password" class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********">
                    </div>
                </div>
                <div class="pb-2">
                    <a href="/forgot-password" class="text-blue-500 font-light hover:underline text-sm hover:text-blue-600">Forgot Password?</a>
                </div>
                <div class="pb-2">
                    <input type="checkbox" id="agree" class="rounded-sm text-blue-500 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-800 dark:focus:border-blue-800" required>
                    <label for="agree" class="text-gray-500 dark:text-gray-400 text-sm font-light">By logging in, you acknowledge and agree you have read and agree to be bound by <a data-modal-target="terms-modal" data-modal-toggle="terms-modal" class="text-blue-500 hover:underline hover:text-blue-600">Terms & Conditions</a> and <a href="#" class="text-blue-500 hover:underline hover:text-blue-600">Privacy Policy</a>.</label>
                </div>
                <div class="">
                    <button type="submit" class="transition-transform duration-300 ease-in-out transform w-full text-lg text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Login</button>
                </div>
            </form>
            <div class="flex gap-2 flex-row items-center">
                <div class="w-1/2 h-[1px] bg-gray-300"></div>
                <p class="text-gray-500">or</p>
                <div class="w-1/2 h-[1px] bg-gray-300"></div>
            </div>
            <div>
                <a href="#" class="border border-gray-300 text-gray-600 p-2 rounded-lg w-full flex items-center justify-center gap-3">
                    <img class="w-5" src="https://www.vectorlogo.zone/logos/google/google-icon.svg" alt="Google Logo">
                    Continue with Google
                </a>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600 hover:underline font-light text-sm">Register</a></p>
            </div>
        </div>
    </div>
</div>

@endsection
