@php
    $chapter = $comic->chapters->first();
    $comments = $chapter ? $chapter->comments()->latest()->with('user')->get() : collect();
@endphp

<div id="komentar" class="mt-10">
    <h2 class="text-2xl font-semibold mb-4">Komentar</h2>

    @auth
    <form id="comment-form" class="mb-6">
        @csrf
        <input type="hidden" name="chapter_id" value="{{ $chapter?->id }}">
        <textarea name="content" rows="3" class="w-full p-3 bg-gray-800 text-white rounded-lg focus:outline-none" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
            Kirim
        </button>
    </form>
    @else
    <p class="text-sm text-gray-400">Silakan <a href="{{ route('login') }}" class="text-blue-400 underline">login</a> untuk menulis komentar.</p>
    @endauth

    <div id="comment-list" class="space-y-4">
        @foreach ($comments as $comment)
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
