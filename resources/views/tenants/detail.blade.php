@extends('layouts.app', ['title' => 'Tenant Detail'])

@section('content')
<h1 class="page-title">Tenant Detail</h1>
<p class="page-subtitle">Users for tenant: {{ $tenant->display_name }}</p>

<table class="users-table">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr></thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No users found for this tenant.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
