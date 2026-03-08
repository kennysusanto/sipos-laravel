@extends('layouts.app', ['title' => 'Unauthorized'])

@section('content')
<h1 class="page-title">Unauthorized</h1>
<p class="page-subtitle">You do not have permission to access this page.</p>

<div class="dashboard-card mt-16 mw-640">
    <p class="unauthorized-message">Please return to dashboard or sign in with an authorized account.</p>
    <a class="btn btn-primary unauthorized-home-btn" href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
@endsection
