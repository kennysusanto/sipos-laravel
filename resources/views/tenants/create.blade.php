@extends('layouts.app', ['title' => 'Create Tenant'])

@section('content')
<h1 class="page-title">Create Tenant</h1>
<p class="page-subtitle">Add a new tenant record.</p>

@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('tenants.store') }}" class="app-form">
    @csrf
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required>

    <label>Display Name</label>
    <input type="text" name="display_name" value="{{ old('display_name') }}" required>

    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>
</form>
</div>
@endsection
