@extends('layouts.app', ['title' => 'Create Menu Item'])

@section('content')
<h1 class="page-title">Create Menu Item</h1>
<p class="page-subtitle">Add a new item to your catalog.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('menuitems.store') }}" class="app-form">
    @csrf
    <label>Display Name</label><input type="text" name="display_name" value="{{ old('display_name') }}" required>
    <label>Internal Name</label><input type="text" name="name" value="{{ old('name') }}" required>
    <label>URL</label><input type="url" name="url" value="{{ old('url') }}">
    <label>Description</label><textarea name="description" required>{{ old('description') }}</textarea>
    <label>Price</label><input type="number" step="0.01" min="0" name="price" value="{{ old('price', 0) }}" required>
    <label>Stock</label><input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" required>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>
</form>
</div>
@endsection
