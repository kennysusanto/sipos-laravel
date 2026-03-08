@extends('layouts.app', ['title' => 'Create Bill'])

@section('content')
<h1 class="page-title">Create Bill</h1>
<p class="page-subtitle">Create a new bill header.</p>

<div class="dashboard-card form-card mt-16">
<form method="POST" action="{{ route('bills.store') }}" class="app-form">
    @csrf
    <label>Table ID</label><input type="number" min="1" name="table_id" value="{{ old('table_id') }}">
    <label>Note</label><input type="text" name="note" value="{{ old('note') }}">
    <div class="form-actions"><button class="btn btn-primary" type="submit">Save</button></div>
</form>
</div>
@endsection
