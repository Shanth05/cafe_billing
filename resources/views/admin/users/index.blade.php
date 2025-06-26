@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">User Role Management</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full table-auto border mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 text-left">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Current Role</th>
                <th class="p-2">Change Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="border-t">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->getRoleNames()->implode(', ') ?: 'No Role' }}</td>
                <td class="p-2">
                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                        @csrf
                        <select name="role" class="border p-1 rounded">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded ml-2">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
