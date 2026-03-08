@extends('layouts.app', ['title' => 'Bill Detail'])

@section('content')
<h1 class="page-title">Bill Detail</h1>
<p class="page-subtitle">Review items in this bill.</p>

<div class="dashboard-card my-16">
    <p><strong>Bill:</strong> #{{ $bill->id }}</p>
    <p><strong>Table:</strong> {{ $bill->table_id }}</p>
    <p><strong>Note:</strong> {{ $bill->note }}</p>
    <div class="form-actions"><a href="{{ route('billitems.create', $bill) }}" class="btn btn-primary">Add Item</a></div>
</div>
<table class="users-table">
    <thead><tr><th>ID</th><th>Menu Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Actions</th></tr></thead>
    <tbody>
        @php $grand = 0; @endphp
        @foreach($items as $item)
            @php
                $price = (float) ($item->menuItem->price ?? 0);
                $subtotal = $price * $item->quantity;
                $grand += $subtotal;
            @endphp
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->menuItem->display_name ?? '-' }}</td>
                <td>{{ number_format($price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($subtotal, 2) }}</td>
                <td>
                    <div class="table-actions">
                    <a href="{{ route('billitems.edit', $item) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('billitems.destroy', $item) }}" class="inline">@csrf @method('DELETE')<button class="btn btn-danger">Delete</button></form>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr><td colspan="4" class="text-right fw-600">Grand Total</td><td class="fw-600">{{ number_format($grand, 2) }}</td><td></td></tr>
    </tbody>
</table>
@endsection
