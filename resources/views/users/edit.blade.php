@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
<h1 class="page-title">Edit User</h1>
<p class="page-subtitle">Update user account details.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('users.update', $user) }}" class="app-form">
    @csrf @method('PUT')
    <label>Tenant</label><select name="tenant_id" required>@foreach($tenants as $tenant)<option value="{{ $tenant->id }}" @selected(old('tenant_id', $user->tenant_id) == $tenant->id)>{{ $tenant->display_name }}</option>@endforeach</select>
    <label>Name</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required>
    <label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    <label>Role</label><select name="role"><option value="admin" @selected(old('role', $user->role) === 'admin')>admin</option><option value="user" @selected(old('role', $user->role) === 'user')>user</option></select>
    <label>Password (optional)</label><input type="password" name="password">
    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button></div>
</form>
</div>
@endsection
