<!-- resources/views/articles/index.blade.php -->
<x-app-layout>
    <x-slot:title>
        Articles
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">Articles</h1>
    </x-slot:header>

    <div class="mb-4">
        <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white p-2 rounded" aria-label="Add New Article">Add New Article</a>
    </div>

    <ul class="mt-4">
        @foreach ($articles as $article)
            <li>
                <strong>{{ $article->title }}</strong> ({{ $article->category->name }}) by {{ $article->user->name }}
                <a href="{{ route('articles.show', $article->id) }}" class="text-blue-500">Read More</a>
            </li>
        @endforeach
    </ul>
</x-app-layout>
