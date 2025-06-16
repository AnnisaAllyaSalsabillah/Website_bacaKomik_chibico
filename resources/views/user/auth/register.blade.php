@extends('layouts.app')

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
</style>

<div class="flex items-center justify-center min-h-screen px-4">
<div class="w-full max-w-md p-8 space-y-8 bg-[#1a1a1a] shadow-lg rounded-xl border border-gray-700">
    <div class="text-center">
    <h2 class="text-3xl font-bold text-[#D7DAE1]">Buat Akun Baru</h2>
    <p class="mt-2 text-sm text-gray-400">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-indigo-400 hover:underline font-medium">Login di sini</a>
    </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <!-- Nama -->
    <div>
        <label for="name" class="block text-sm text-[#D7DAE1]">Nama Lengkap</label>
        <input 
        id="name" 
        name="name" 
        type="text" 
        value="{{ old('name') }}" 
        required
        class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
        placeholder="Nama lengkap"
        >
        @error('name')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm text-[#D7DAE1]">Email</label>
        <input 
        id="email" 
        name="email" 
        type="email" 
        value="{{ old('email') }}" 
        required
        class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
        placeholder="Alamat email"
        >
        @error('email')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm text-[#D7DAE1]">Password</label>
        <input 
        id="password" 
        name="password" 
        type="password" 
        required
        class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
        placeholder="Masukkan password"
        >
        @error('password')
        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label for="password_confirmation" class="block text-sm text-[#D7DAE1]">Konfirmasi Password</label>
        <input 
        id="password_confirmation" 
        name="password_confirmation" 
        type="password" 
        required
        class="w-full px-4 py-2 rounded-md bg-[#111] border border-gray-600 text-[#D7DAE1] focus:outline-none focus:ring-2 focus:ring-indigo-500"
        placeholder="Konfirmasi password"
        >
    </div>

    <!-- Tombol -->
    <div>
        <button 
        type="submit"
        class="w-full py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition"
        >
        Buat Akun
        </button>
    </div>
    </form>
</div>
</div>
@endsection