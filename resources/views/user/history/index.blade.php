@extends('layouts.app')

@section('title', 'Riwayat Baca')

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Riwayat Baca</h1>

        <div id="history-container" class="space-y-4">
            <p class="text-gray-400 text-sm">Memuat riwayat...</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    async function loadHistory() {
        const container = document.getElementById('history-container');
        try {
            const response = await fetch("{{ route('user.history.index') }}");
            const data = await response.json();

            if (data.length === 0) {
                container.innerHTML = `<p class="text-gray-500">Belum ada riwayat baca.</p>`;
                return;
            }

            container.innerHTML = '';
            data.forEach(item => {
                const comic = item.comic;
                const html = `
                    <a href="/user/komiks/${comic.slug}" class="block bg-gray-900 rounded-lg p-4 hover:bg-gray-800 transition">
                        <h2 class="text-xl font-semibold">${comic.title}</h2>
                        <p class="text-gray-400 text-sm mt-1">Terakhir dibaca pada chapter ID: ${item.chapter_id}</p>
                        <p class="text-gray-500 text-xs mt-1">Update: ${new Date(item.updated_at).toLocaleString('id-ID')}</p>
                    </a>
                `;
                container.insertAdjacentHTML('beforeend', html);
            });
        } catch (error) {
            container.innerHTML = `<p class="text-red-500">Gagal memuat riwayat.</p>`;
        }
    }

    document.addEventListener('DOMContentLoaded', loadHistory);
</script>
@endpush
@endsection
