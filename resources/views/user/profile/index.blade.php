@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white shadow-sm rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
                <p class="text-sm text-gray-600 mt-1">Manage your personal information</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <!-- Profile Picture -->
                    <div class="flex-shrink-0">
                        @if($user->profile_picture)
                            <img class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover" 
                                 src="{{ asset('storage/' . $user->profile_picture) }}" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="text-white">
                        <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                        @if($user->username)
                            <p class="text-blue-100 text-lg">@<span class="font-medium">{{ $user->username }}</span></p>
                        @endif
                        <p class="text-blue-100 mt-2">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            Personal Information
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <span class="w-20 text-gray-500 font-medium">Name:</span>
                                <span class="text-gray-900">{{ $user->name }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <span class="w-20 text-gray-500 font-medium">Username:</span>
                                <span class="text-gray-900">{{ $user->username ?? 'Not set' }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <span class="w-20 text-gray-500 font-medium">Email:</span>
                                <span class="text-gray-900">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                            Account Information
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm">
                                <span class="w-24 text-gray-500 font-medium">Member since:</span>
                                <span class="text-gray-900">{{ $user->created_at->format('F j, Y') }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <span class="w-24 text-gray-500 font-medium">Last updated:</span>
                                <span class="text-gray-900">{{ $user->updated_at->format('F j, Y') }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm">
                                <span class="w-24 text-gray-500 font-medium">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('user.profile.edit') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    
                    <button type="button" 
                            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection