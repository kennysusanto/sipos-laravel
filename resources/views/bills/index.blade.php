@extends('layouts.app', ['title' => 'Bills'])

@section('content')
<h1 class="page-title">Bills</h1>
<p class="page-subtitle">Manage bill headers and details.</p>

<div class="page-header-actions"><a href="{{ route('bills.create') }}" class="btn btn-primary">Create Bill</a></div>
<table class="users-table">
    <thead><tr><th>ID</th><th>Table</th><th>Note</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->id }}</td>
                <td>
                    <span class="bill-meta-pill">{{ $bill->table_id ? 'Table '.$bill->table_id : 'No Table' }}</span>
                </td>
                <td>
                    @if(!empty($bill->note))
                        <span class="bill-note">{{ $bill->note }}</span>
                    @else
                        <span class="bill-note-muted">No note</span>
                    @endif
                </td>
                <td>
                    <div class="table-actions">
                    <a href="{{ route('bills.detail', $bill) }}" class="btn">Detail</a>
                    <a href="{{ route('bills.edit', $bill) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('bills.destroy', $bill) }}" class="inline">@csrf @method('DELETE')<button class="btn btn-danger">Delete</button></form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
