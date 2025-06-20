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

    .input-error {
        border-color: #f87171 !important;
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

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .loading-overlay.show {
        opacity: 1;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #333;
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .label-text {
        color: #D7DAE1 !important;
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
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-base-200 border border-base-300 shadow rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
            <div>
                <h3 class="text-lg font-semibold text-base-content mb-4">Profile Picture</h3>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0 relative">
                        @if($user->profile_photo)
                            <img id="current-avatar"
                                class="w-20 h-20 rounded-full object-cover border border-base-content/20"
                                src="{{ $user->profile_photo }}?tr=w-80,h-80,q-90,c-maintain_ratio"
                                alt="{{ $user->name }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}'; this.classList.add('opacity-75');">
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
                        
                        <!-- Loading overlay -->
                        <div id="image-loading" class="loading-overlay">
                            <div class="spinner"></div>
                        </div>
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
                            accept="image/jpeg,image/png,image/jpg,image/gif" class="hidden"
                            onchange="previewImage(this)">
                        
                        <!-- Image info -->
                        <div class="mt-2 space-y-1">
                            <p class="text-xs text-base-content/60">JPG, PNG, GIF up to 2MB</p>
                            <div id="file-info" class="text-xs text-base-content/60" style="display: none;"></div>
                        </div>
                        
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
            <div class="flex flex-col sm:flex-row gap-4 justify-end border-t border-base-content/20 pt-6">
                <a href="{{ route('user.profile.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary gap-2" id="save-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                    <span id="save-text">Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const loadingOverlay = document.getElementById('image-loading');
        const fileInfo = document.getElementById('file-info');
        const newImagePreview = document.getElementById('new-image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('File type not allowed. Please select JPG, PNG, or GIF image.');
                clearImagePreview();
                return;
            }
            
            // Show loading
            loadingOverlay.classList.add('show');
            
            // Display file info
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            fileInfo.innerHTML = `Selected: ${file.name} (${fileSize} MB)`;
            fileInfo.style.display = 'block';
            
            // Validate file size (2MB = 2048KB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size too large. Please select an image under 2MB.');
                clearImagePreview();
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function (e) {
                // Hide loading
                loadingOverlay.classList.remove('show');
                
                // Update current avatar
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
                
                // Show new image preview
                previewImg.src = e.target.result;
                newImagePreview.classList.remove('hidden');
            }
            
            reader.onerror = function() {
                loadingOverlay.classList.remove('show');
                alert('Error reading file. Please try again.');
                clearImagePreview();
            }
            
            reader.readAsDataURL(file);
        }
    }
    
    function clearImagePreview() {
        const input = document.getElementById('profile_photo');
        const fileInfo = document.getElementById('file-info');
        const newImagePreview = document.getElementById('new-image-preview');
        const currentAvatar = document.getElementById('current-avatar');
        
        // Clear input
        input.value = '';
        
        // Hide file info
        fileInfo.style.display = 'none';
        
        // Hide new image preview
        newImagePreview.classList.add('hidden');
        
        // Restore original avatar
        @if($user->profile_photo)
            if (currentAvatar.tagName === 'IMG') {
                currentAvatar.src = "{{ $user->profile_photo }}?tr=w-80,h-80,q-90,c-maintain_ratio";
            }
        @else
            // Restore default avatar div
            const defaultDiv = document.createElement('div');
            defaultDiv.id = 'current-avatar';
            defaultDiv.className = 'w-20 h-20 rounded-full border border-base-content/20 bg-base-300 flex items-center justify-center';
            defaultDiv.innerHTML = `
                <svg class="w-8 h-8 text-base-content/40" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            `;
            currentAvatar.parentNode.replaceChild(defaultDiv, currentAvatar);
        @endif
    }
    
    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(e) {
        const saveBtn = document.getElementById('save-btn');
        const saveText = document.getElementById('save-text');
        
        // Disable button to prevent double submission
        saveBtn.disabled = true;
        saveText.textContent = 'Saving...';
        
        // Re-enable after 15 seconds as fallback
        setTimeout(() => {
            saveBtn.disabled = false;
            saveText.textContent = 'Save Changes';
        }, 15000);
    });

    // Additional validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('name');
        const usernameInput = document.getElementById('username');
        
        // Check if required fields are filled
        if (!nameInput.value.trim()) {
            e.preventDefault();
            alert('Full Name is required.');
            nameInput.focus();
            return;
        }
        
        if (!usernameInput.value.trim()) {
            e.preventDefault();
            alert('Username is required.');
            usernameInput.focus();
            return;
        }
        
        // Check username format (alphanumeric and underscore only)
        const usernamePattern = /^[a-zA-Z0-9_]+$/;
        if (!usernamePattern.test(usernameInput.value)) {
            e.preventDefault();
            alert('Username can only contain letters, numbers, and underscores.');
            usernameInput.focus();
            return;
        }
    });
</script>
@endsection