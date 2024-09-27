<!-- resources/views/comments/index.blade.php -->
<x-app-layout>
    <x-slot:title>
        Manage Comments
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">Manage Comments</h1>
    </x-slot:header>

    <table class="table-auto w-full mb-8">
        <thead>
            <tr>
                <th class="px-4 py-2">Article</th>
                <th class="px-4 py-2">Comment</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td class="border px-4 py-2">{{ $comment->article->title }}</td>
                    <td class="border px-4 py-2">{{ $comment->content }}</td>
                    <td class="border px-4 py-2">{{ $comment->user->name }}</td>
                    <td class="border px-4 py-2">
                        @if (!$comment->approved)
                            <form action="{{ route('comments.approve', $comment->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                            </form>
                        @endif
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                            class="inline-block ml-2" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this comment?");
        }
    </script>
</x-app-layout>
