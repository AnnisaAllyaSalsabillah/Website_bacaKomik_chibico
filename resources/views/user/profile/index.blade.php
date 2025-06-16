@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="min-h-screen w-full bg-[#0b0b0f] px-6 py-10 font-inter text-white relative z-0">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,_var(--tw-gradient-stops))] from-pink-800/10 via-[#1a1b23]/50 to-transparent blur-3xl z-[-1]"></div>
@if(session('success'))
        <div class="max-w-4xl mx-auto mb-8 animate-fade-in-down">
            <div class="bg-pink-800/20 border border-pink-500/40 rounded-xl p-4 text-sm text-pink-200 shadow-lg backdrop-blur">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif
    <!-- Header -->
<div class="mb-12 text-center">
    <h1 class="text-6xl font-extrabold text-white drop-shadow-glow">
        Profile
    </h1>
    <p class="text-white text-sm mt-2 tracking-wide">Welcome back, {{ $user->name }}.</p>
</div>

    <!-- Profile Card -->
    <div class="w-full px-4 md:px-10 xl:px-32">
        <div class="bg-[#15151c]/90 border border-[#393451] rounded-2xl shadow-[0_0_60px_rgba(255,0,150,0.05)] backdrop-blur-md p-10">
            <!-- Top Section -->
            <div class="flex flex-col md:flex-row items-center gap-8 mb-10">
                <!-- Profile Picture -->
                <div>
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                             class="w-32 h-32 rounded-full border-4 border-pink-300 object-cover shadow-[0_0_25px_rgba(255,192,203,0.5)] transition duration-300"
                             alt="{{ $user->name }}">
                    @else
                        <div class="w-32 h-32 rounded-full bg-[#2e2b3b] border-4 border-pink-300 flex items-center justify-center shadow-lg">
                            <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-pink-200">{{ $user->name }}</h2>
                    <p class="text-pink-100 text-sm">@<span class="font-mono">{{ $user->username }}</span></p>
                    <p class="text-pink-100 text-xs mt-1">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Personal -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-400 mb-4 border-b border-pink-500 pb-1">✨ Personal Info</h3>
                    <ul class="space-y-3 text-sm">
                        <li><span class="text-pink-300 inline-block w-28">Name:</span> {{ $user->name }}</li>
                        <li><span class="text-pink-300 inline-block w-28">Username:</span> {{ $user->username ?? 'Not set' }}</li>
                        <li><span class="text-pink-300 inline-block w-28">Email:</span> {{ $user->email }}</li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h3 class="text-lg font-semibold text-pink-400 mb-4 border-b border-pink-500 pb-1">🔐 Account Info</h3>
                    <ul class="space-y-3 text-sm">
                        <li><span class="text-pink-300 inline-block w-32">Member since:</span> {{ $user->created_at->format('F j, Y') }}</li>
                        <li><span class="text-pink-300 inline-block w-32">Last update:</span> {{ $user->updated_at->format('F j, Y') }}</li>
                        <li>
                            <span class="text-pink-300 inline-block w-32">Status:</span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600/20 text-green-300 shadow-inner backdrop-blur">
                                Active
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col sm:flex-row justify-between gap-4 items-start sm:items-center">
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('user.profile.edit') }}"
                        class="inline-flex items-center px-6 py-3 rounded-xl bg-pink-600 hover:bg-pink-700 text-white shadow-lg hover:shadow-pink-500/30 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>

                    <a href="{{ route('user.profile.password.edit') }}"
                        class="inline-flex items-center px-6 py-3 rounded-xl bg-[#2a2736] hover:bg-[#3a3750] text-gray-100 border border-pink-600 shadow-lg hover:shadow-pink-300/20 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Change Password
                    </a>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white shadow-lg hover:shadow-red-400/30 transition-all duration-300 ml-auto">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
