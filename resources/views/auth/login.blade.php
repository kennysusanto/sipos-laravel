@extends('layouts.app', ['title' => 'Login'])

@section('content')
<div class="login-page">
    <div class="login-theme-toggle">
        <label class="theme-switch" title="Toggle theme">
            <span class="visually-hidden">Toggle theme</span>
            <input id="theme-toggle" type="checkbox" aria-label="Toggle theme">
            <span class="theme-slider"></span>
        </label>
    </div>

    <div class="github-login-box">
        <div class="sipos-logo-mark">S</div>
        <h2>SIPOS</h2>
        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
