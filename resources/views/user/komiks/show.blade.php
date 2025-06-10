@extends('layouts.app')
@include('user.comment.index', ['comic' => $comic])
@section('title', $comic->title)

@section('content')
<div class="bg-black text-[#D7DAE1] min-h-screen py-10">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-6 mb-10">
            <img src="{{ $comic->cover }}" alt="{{ $comic->title }}" class="w-full md:w-64 h-auto rounded-lg shadow-md">
            
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $comic->title }}</h1>
                <p class="mb-4 text-gray-300">
                    Genre: <span class="text-white">{{ $comic->genres->pluck('name')->join(', ') }}</span>
                </p>

                <div class="space-y-2">
                    <h2 class="text-xl font-semibold border-b border-gray-700 pb-2">Daftar Chapter</h2>
                    <ul class="space-y-1">
                        @foreach ($comic->chapters as $chapter)
                            <li>
                                <a href="{{ route('user.chapters.show', $chapter->id) }}" class="text-blue-400 hover:underline">
                                    Chapter {{ $chapter->number }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Komentar -->
        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4">Komentar</h2>

            <!-- Form Komentar -->
            @auth
            <form id="comment-form" class="mb-6">
                @csrf
                <input type="hidden" name="chapter_id" value="{{ $comic->chapters->first()?->id }}">
                <textarea name="content" rows="3" class="w-full p-3 bg-gray-800 text-white rounded-lg focus:outline-none" placeholder="Tulis komentar..."></textarea>
                <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                    Kirim
                </button>
            </form>
            @else
            <p class="text-sm text-gray-400">Silakan <a href="{{ route('login') }}" class="text-blue-400 underline">login</a> untuk menulis komentar.</p>
            @endauth

            <!-- Daftar Komentar -->
            <div id="comment-list" class="space-y-4">
                @foreach($comic->chapters->first()?->comments()->latest()->with('user')->get() ?? [] as $comment)
                    <div class="bg-gray-900 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-white">{{ $comment->user->name }}</span>
                            @if(Auth::id() === $comment->user_id)
                                <button class="text-red-500 text-sm delete-comment" data-id="{{ $comment->id }}">Hapus</button>
                            @endif
                        </div>
                        <p class="text-gray-300 mt-1">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('comment-form');
    const commentList = document.getElementById('comment-list');

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const res = await fetch("{{ route('user.comment.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await res.json();

        if (data.status === 'success') {
            const comment = data.comment;
            const newComment = `
                <div class="bg-gray-900 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-white">${comment.user.name}</span>
                        <button class="text-red-500 text-sm delete-comment" data-id="${comment.id}">Hapus</button>
                    </div>
                    <p class="text-gray-300 mt-1">${comment.content}</p>
                </div>
            `;
            commentList.insertAdjacentHTML('afterbegin', newComment);
            form.reset();
        }
    });

    commentList.addEventListener('click', async (e) => {
        if (e.target.classList.contains('delete-comment')) {
            const commentId = e.target.dataset.id;
            const res = await fetch(`/user/comment/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            });

            const data = await res.json();
            if (data.status === 'deleted') {
                e.target.closest('.bg-gray-900').remove();
            }
        }
    });
});
</script>
@endpush
