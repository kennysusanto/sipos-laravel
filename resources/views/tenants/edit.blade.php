@extends('layouts.app', ['title' => 'Edit Tenant'])

@section('content')
<h1 class="page-title">Edit Tenant</h1>
<p class="page-subtitle">Update tenant details.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('tenants.update', $tenant) }}" class="app-form">
    @csrf @method('PUT')
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required>

    <label>Display Name</label>
    <input type="text" name="display_name" value="{{ old('display_name', $tenant->display_name) }}" required>

    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button></div>
</form>
</div>
@endsection
