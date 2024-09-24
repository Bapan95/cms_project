<!-- resources/views/articles/show.blade.php -->
<x-app-layout>
    <x-slot:title>
        {{ $article->title }}
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">{{ $article->title }}</h1>
        <p>Category: {{ $article->category->name }}</p>
        <p>Written by {{ $article->user->name }}</p>
    </x-slot:header>

    <div class="mb-6">
        <p>{{ $article->content }}</p>
    </div>

    <!-- Comments Section -->
    <h3 class="text-xl font-bold mt-8">Comments</h3>
    <ul>
        @foreach ($article->comments as $comment)
            @if ($comment->approved)
                <li class="mb-4">
                    <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                </li>
            @endif
        @endforeach
    </ul>

    @auth
        <h3 class="text-xl font-bold mt-8">Add Comment</h3>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            
            <div class="mb-4">
                <textarea name="content" rows="3" class="border p-2 w-full" placeholder="Add your comment..." required></textarea>
            </div>
        
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Post Comment</button>
        </form>        
        
    @else
        <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> to add a comment.</p>
    @endauth
</x-app-layout>
