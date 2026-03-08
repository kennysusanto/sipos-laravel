@extends('layouts.app', ['title' => 'Edit Menu Item'])

@section('content')
<h1 class="page-title">Edit Menu Item</h1>
<p class="page-subtitle">Update item details.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('menuitems.update', $item) }}" class="app-form">
    @csrf @method('PUT')
    <label>Display Name</label><input type="text" name="display_name" value="{{ old('display_name', $item->display_name) }}" required>
    <label>Internal Name</label><input type="text" name="name" value="{{ old('name', $item->name) }}" required>
    <label>URL</label><input type="url" name="url" value="{{ old('url', $item->url) }}">
    <label>Description</label><textarea name="description" required>{{ old('description', $item->description) }}</textarea>
    <label>Price</label><input type="number" step="0.01" min="0" name="price" value="{{ old('price', $item->price) }}" required>
    <label>Stock</label><input type="number" min="0" name="stock" value="{{ old('stock', $item->stock) }}" required>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button></div>
</form>
</div>
@endsection
