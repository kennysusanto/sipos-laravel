@extends('layouts.app', ['title' => 'Edit Bill Item'])

@section('content')
<h1 class="page-title">Edit Bill Item</h1>
<p class="page-subtitle">Update bill item details.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('billitems.update', $billItem) }}" class="app-form">
    @csrf @method('PUT')
    <label>Menu Item</label><select name="menu_item_id" required>@foreach($menuItems as $item)<option value="{{ $item->id }}" @selected(old('menu_item_id', $billItem->menu_item_id) == $item->id)>{{ $item->display_name }} ({{ number_format($item->price, 2) }})</option>@endforeach</select>
    <label>Quantity</label><input type="number" min="1" name="quantity" value="{{ old('quantity', $billItem->quantity) }}" required>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button></div>
</form>
</div>
@endsection
