@if ($type === 'edit')
    <a href="{{ route('profile.edit', $user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded" aria-label="Edit {{ $user->name }}">
        Edit
    </a>
@elseif ($type === 'delete')
    <form action="{{ route('profile.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" aria-label="Delete {{ $user->name }}">
            Delete
        </button>
    </form>
@endif
