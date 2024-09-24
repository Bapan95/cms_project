<!-- resources/views/categories/create.blade.php -->
<x-app-layout>
    <x-slot:title>
        Create Category
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">Create New Category</h1>
    </x-slot:header>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block">Category Name:</label>
            <input type="text" name="name" id="name" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="parent_id" class="block">Parent Category:</label>
            <select name="parent_id" id="parent_id" class="border p-2 w-full">
                <option value="">None</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Category</button>
    </form>
</x-app-layout>
