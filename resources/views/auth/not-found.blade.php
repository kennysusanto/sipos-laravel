@extends('layouts.app', ['title' => 'Not Found'])

@section('content')
<h1 class="page-title">Not Found</h1>
<p class="page-subtitle">The requested page was not found.</p>

<div class="dashboard-card mt-16 mw-640">
    <p class="unauthorized-message">The page may have been moved or deleted.</p>
    <a class="btn btn-primary unauthorized-home-btn" href="{{ route('dashboard') }}">Back to Dashboard</a>
</div>
@endsection
