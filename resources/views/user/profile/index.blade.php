@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto bg-base-200 rounded-xl shadow-lg p-6 space-y-6">

  <div class="flex items-center justify-between border-b border-gray-700 pb-4">
    <h2 class="text-2xl font-bold">My Profile</h2>
    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary btn-sm">Edit</a>
  </div>

  <div class="flex flex-col sm:flex-row items-center gap-6">
    <div class="avatar">
      <div class="w-28 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
        <img src="{{ $user->profile_picture ?? asset('images/profile.png') }}" alt="Profile Picture">
      </div>
    </div>

    <div class="text-center sm:text-left space-y-2">
      <h3 class="text-xl font-semibold">{{ $user->name }}</h3>
      <p class="text-sm text-gray-400">{{ $user->email }}</p>
      <p class="text-sm text-gray-500">Joined: {{ $user->created_at->format('d M Y') }}</p>
    </div>
  </div>

  <div class="grid sm:grid-cols-2 gap-4 pt-6">
    <div>
      <label class="text-sm text-gray-400">Username</label>
      <div class="text-base font-medium">{{ $user->username ?? '-' }}</div>
    </div>
    <div>
      <label class="text-sm text-gray-400">Role</label>
      <div class="text-base font-medium capitalize">{{ $user->role ?? 'user' }}</div>
    </div>
    <!-- Tambahan info lainnya bisa ditambahkan di sini -->
  </div>

</div>
@endsection
