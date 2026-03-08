@extends('layouts.app', ['title' => 'Profile'])

@section('content')
<h1 class="page-title">Profile</h1>
<p class="page-subtitle">Your account information.</p>

<div class="dashboard-card mt-16 mw-640">
    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
</div>
@endsection
