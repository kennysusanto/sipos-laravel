@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<h1 class="page-title">Dashboard</h1>
<p class="page-subtitle">Welcome, {{ auth()->user()->name }}.</p>

<div class="dashboard-cards">
    <article class="dashboard-card">
        <div class="card-title">Role</div>
        <div class="card-value">{{ auth()->user()->role }}</div>
    </article>
    <article class="dashboard-card">
        <div class="card-title">Tenant</div>
        <div class="card-value">{{ auth()->user()->tenant?->display_name }}</div>
    </article>
</div>
@endsection
