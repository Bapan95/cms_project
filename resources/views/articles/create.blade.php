<!-- resources/views/articles/create.blade.php -->
<x-app-layout>
    <x-slot:title>
        Create Article
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">Create New Article</h1>
    </x-slot:header>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="title" class="block">Title:</label>
            <input type="text" name="title" id="title" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block">Category:</label>
            <select name="category_id" id="category_id" class="border p-2 w-full">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="content" class="block">Content:</label>
            <textarea name="content" id="content" rows="5" class="border p-2 w-full" required></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Article</button>
    </form>
</x-app-layout>
