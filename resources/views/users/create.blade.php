@extends('layouts.app', ['title' => 'Create User'])

@section('content')
<h1 class="page-title">Create User</h1>
<p class="page-subtitle">Add a new user account.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('users.store') }}" class="app-form">
    @csrf
    <label>Tenant</label><select name="tenant_id" required>@foreach($tenants as $tenant)<option value="{{ $tenant->id }}" @selected(old('tenant_id') == $tenant->id)>{{ $tenant->display_name }}</option>@endforeach</select>
    <label>Name</label><input type="text" name="name" value="{{ old('name') }}" required>
    <label>Email</label><input type="email" name="email" value="{{ old('email') }}" required>
    <label>Role</label><select name="role"><option value="admin" @selected(old('role') === 'admin')>admin</option><option value="user" @selected(old('role', 'user') === 'user')>user</option></select>
    <label>Password</label><input type="password" name="password" required>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>
</form>
</div>
@endsection
