@extends('layouts.app', ['title' => 'Tenants'])

@section('content')
<h1 class="page-title">Tenants</h1>
<p class="page-subtitle">Manage tenant records.</p>

<div class="page-header-actions"><a href="{{ route('tenants.create') }}" class="btn btn-primary">Create Tenant</a></div>
<table class="users-table">
    <thead><tr><th>ID</th><th>Name</th><th>Display Name</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($tenants as $tenant)
            <tr>
                <td>{{ $tenant->id }}</td>
                <td>{{ $tenant->name }}</td>
                <td>{{ $tenant->display_name }}</td>
                <td>
                    <div class="table-actions">
                    <a href="{{ route('tenants.detail', $tenant) }}" class="btn">Users</a>
                    <a href="{{ route('tenants.edit', $tenant) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('tenants.destroy', $tenant) }}" class="inline">
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
