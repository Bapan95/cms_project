<tr>
    <td class="border px-4 py-2">{{ $user->name }}</td>
    <td class="border px-4 py-2">{{ $user->email }}</td>
    <td class="border px-4 py-2">{{ $user->role }}</td>
    <td class="border px-4 py-2 flex space-x-2">
        <x-action-button type="edit" :user="$user" />
        <x-action-button type="delete" :user="$user" />
    </td>
</tr>
