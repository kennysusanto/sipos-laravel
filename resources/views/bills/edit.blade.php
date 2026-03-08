@extends('layouts.app', ['title' => 'Edit Bill'])

@section('content')
<h1 class="page-title">Edit Bill</h1>
<p class="page-subtitle">Update bill header details.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('bills.update', $bill) }}" class="app-form">
    @csrf @method('PUT')
    <label>Table ID</label><input type="number" min="1" name="table_id" value="{{ old('table_id', $bill->table_id) }}">
    <label>Note</label><input type="text" name="note" value="{{ old('note', $bill->note) }}">
    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button></div>
</form>
</div>
@endsection
