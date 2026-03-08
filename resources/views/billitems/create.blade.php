@extends('layouts.app', ['title' => 'Add Bill Item'])

@section('content')
<h1 class="page-title">Add Bill Item</h1>
<p class="page-subtitle">Add a menu item into the selected bill.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('billitems.store', $bill) }}" class="app-form">
    @csrf
    <label>Menu Item</label><select name="menu_item_id" required>@foreach($menuItems as $item)<option value="{{ $item->id }}" @selected(old('menu_item_id') == $item->id)>{{ $item->display_name }} ({{ number_format($item->price, 2) }})</option>@endforeach</select>
    <label>Quantity</label><input type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" required>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>
</form>
</div>
@endsection
