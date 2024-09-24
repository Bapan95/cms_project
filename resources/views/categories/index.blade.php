<!-- resources/views/categories/index.blade.php -->
<x-app-layout>
    <x-slot:title>
        Categories
    </x-slot:title>

    <x-slot:header>
        <h1 class="text-2xl font-bold mb-4">Categories</h1>
    </x-slot:header>

    <!-- Add New Category Button -->
    <div class="mb-4">
        <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white p-2 rounded" aria-label="Add New Category">Add New Category</a>
    </div>

    <!-- Categories Table -->
    <table class="min-w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Category Name</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                        </form>
                        @if ($category->children)
                            <ul class="ml-4">
                                @foreach ($category->children as $child)
                                    <li class="border border-gray-300 px-4 py-2">
                                        {{ $child->name }}
                                        <a href="{{ route('categories.edit', $child->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('categories.destroy', $child->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this category?');">Delete</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
