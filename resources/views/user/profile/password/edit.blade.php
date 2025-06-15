@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

<div class="min-h-screen py-12 bg-base-100">
    <div class="max-w-2xl mx-auto bg-base-200 p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Change Password</h1>

        <form method="POST" action="{{ route('user.profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="current_password" class="block font-medium mb-2">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="input input-bordered w-full" required>
                @error('current_password')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_password" class="block font-medium mb-2">New Password</label>
                <input type="password" name="new_password" id="new_password" class="input input-bordered w-full" required>
                @error('new_password')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new_password_confirmation" class="block font-medium mb-2">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="input input-bordered w-full" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('user.profile.index') }}" class="btn btn-outline mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
