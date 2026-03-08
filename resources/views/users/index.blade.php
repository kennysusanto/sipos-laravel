@extends('layouts.app', ['title' => 'Users'])

@section('content')
<h1 class="page-title">Users</h1>
<p class="page-subtitle">Manage users and roles.</p>

@if(!empty($error))
    <div class="alert alert-error">{{ $error }}</div>
@endif

<div class="page-header-actions"><a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a></div>
<table class="users-table">
    <thead><tr><th>ID</th><th>Tenant</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->tenant?->display_name }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <div class="table-actions">
                    <a href="{{ route('users.edit', $user) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
