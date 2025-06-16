@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<style>
    body {
      background-color: #000000;
      color: #D7DAE1;
    }

    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-thumb {
      background: #333;
      border-radius: 10px;
    }

    .bg-base-100,
    .bg-base-200 {
      background-color: #111 !important;
    }

    .text-base-content {
      color: #D7DAE1 !important;
    }

    .text-base-content\/60 {
      color: rgba(215, 218, 225, 0.6) !important;
    }

    .border-base-300 {
      border-color: #333 !important;
    }

    .border-base-content\/20 {
      border-color: rgba(215, 218, 225, 0.2) !important;
    }

    .text-error {
      color: #f87171 !important;
    }

    .input,
    .input-bordered {
      background-color: #1a1a1a !important;
      border-color: #333 !important;
      color: #D7DAE1 !important;
    }

    .input-disabled {
      background-color: #1a1a1a !important;
      color: #888 !important;
    }

    .btn-outline {
      border-color: #D7DAE1 !important;
      color: #D7DAE1 !important;
    }

    .btn-primary {
      background-color: #3b82f6 !important;
      border-color: #3b82f6 !important;
      color: #fff !important;
    }

    .btn-outline:hover {
      background-color: #222 !important;
    }
</style>

<div class="min-h-screen py-8 bg-base-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Header -->
        <div class="bg-base-200 shadow rounded-xl p-6 border border-base-300">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-base-content">Edit Profile</h1>
                    <p class="text-sm text-base-content/60">Update your personal information</p>
                </div>
                <a href="{{ route('user.profile.index') }}"
                   class="btn btn-sm btn-outline text-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
              class="bg-base-200 border border-base-300 shadow rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
            <div>
                <h3 class="text-lg font-semibold text-base-content mb-4">Profile Picture</h3>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if($user->profile_photo)
                            <img id="current-avatar"
                                 class="w-20 h-20 rounded-full object-cover border border-base-content/20"
                                 src="{{ asset('storage/' . $user->profile_photo) }}"
                                 alt="{{ $user->name }}">
                        @else
                            <div id="current-avatar"
                                 class="w-20 h-20 rounded-full border border-base-content/20 bg-base-300 flex items-center justify-center">
                                <svg class="w-8 h-8 text-base-content/40" fill="currentColor"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label for="profile_photo"
                               class="btn btn-outline btn-sm cursor-pointer gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload New Picture
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo"
                               accept="image/*" class="hidden"
                               onchange="previewImage(this)">
                        <p class="text-xs text-base-content/60 mt-2">JPG, PNG, GIF up to 2MB</p>
                        @error('profile_photo')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-semibold text-base-content mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="label">
                            <span class="label-text font-medium">Full Name *</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               required
                               class="input input-bordered w-full @error('name') input-error @enderror">
                        @error('name')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Username -->
                    <div>
                        <label for="username" class="label">
                            <span class="label-text font-medium">Username *</span>
                        </label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                            required
                            class="input input-bordered w-full @error('username') input-error @enderror">
                        @error('username')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('user.profile.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const currentAvatar = document.getElementById('current-avatar');
                if (currentAvatar.tagName === 'IMG') {
                    currentAvatar.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.id = 'current-avatar';
                    img.className = 'w-20 h-20 rounded-full object-cover border border-base-content/20';
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    currentAvatar.parentNode.replaceChild(img, currentAvatar);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
