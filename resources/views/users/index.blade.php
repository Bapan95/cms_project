<x-app-layout>
    <x-slot:title>
        User Management
    </x-slot:title>

    <h1 class="text-2xl font-bold mb-4">User Management</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add User Button -->
    <div class="mb-4">
        <a href="{{ route('register') }}" class="bg-blue-500 text-white px-4 py-2 rounded" aria-label="Add New User">Add New User</a>
    </div>

    <table class="table-auto w-full mb-8 border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->role }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('profile.edit', $user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded" aria-label="Edit {{ $user->name }}">Edit</a>
                        
                        <!-- Delete Form -->
                        <form action="{{ route('profile.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" aria-label="Delete {{ $user->name }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-app-layout>
