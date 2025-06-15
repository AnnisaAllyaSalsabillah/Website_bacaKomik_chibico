@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center py-0 px-4 sm:px-0 lg:px-0 bg-[#000000FF]">
    <div class="w-full max-w-md p-8 space-y-8 bg-[#1a1a1a] shadow-lg rounded-xl border border-gray-700 ">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-[#D7DAE1]">Sign in to your account</h2>
        <p class="mt-2 text-sm text-gray-400">
        Or
        <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">
            create a new account
        </a>
        </p>
    </div>

    <form class="mt-6 space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="space-y-4">
        <div>
            <label for="email" class="block text-sm text-[#D7DAE1]">Email address</label>
            <input
            id="email"
            name="email"
            type="email"
            required
            value="{{ old('email') }}"
            class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
            >
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm text-[#D7DAE1]">Password</label>
            <input
            id="password"
            name="password"
            type="password"
            required
            class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
            >
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input
            id="remember"
            name="remember"
            type="checkbox"
            class="checkbox checkbox-sm bg-[#111] border-gray-600 text-indigo-500"
            >
            <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
        </div>

        <button
            type="submit"
            class="w-full py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition"
        >
            Sign In
        </button>
        </div>
    </form>
    </div>
</div>
@endsection