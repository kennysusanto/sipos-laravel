<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIPOS' }}</title>
    <script>
        (() => {
            const STORAGE_KEY = 'theme';
            const savedTheme = localStorage.getItem(STORAGE_KEY);
            const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme === 'dark' || savedTheme === 'light' ? savedTheme : preferredTheme;
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $routeName = request()->route()?->getName() ?? '';
        $activePage = match (true) {
            str_starts_with($routeName, 'tenants.') => 'tenants',
            str_starts_with($routeName, 'users.') => 'users',
            str_starts_with($routeName, 'menuitems.') => 'menuitems',
            str_starts_with($routeName, 'billitems.'), str_starts_with($routeName, 'bills.') => 'bills',
            str_starts_with($routeName, 'cashiermenu.') => 'cashiermenu',
            str_starts_with($routeName, 'profile.') => 'profile',
            default => 'dashboard',
        };
    @endphp

    @auth
        <div class="dashboard-wrapper">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <div class="sidebar-brand-mark">S</div>
                    <h2>SIPOS</h2>
                </div>
                <ul>
                    <li><a href="{{ route('dashboard') }}" class="{{ $activePage === 'dashboard' ? 'active' : '' }}">Home</a></li>
                    @if(auth()->user()->role === 'admin' && auth()->user()->tenant?->name === 'master')
                        <li><a href="{{ route('tenants.index') }}" class="{{ $activePage === 'tenants' ? 'active' : '' }}">Tenants</a></li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('users.index') }}" class="{{ $activePage === 'users' ? 'active' : '' }}">Users</a></li>
                        <li><a href="{{ route('menuitems.index') }}" class="{{ $activePage === 'menuitems' ? 'active' : '' }}">Menu Items</a></li>
                    @endif
                    <li><a href="{{ route('bills.index') }}" class="{{ $activePage === 'bills' ? 'active' : '' }}">Bills</a></li>
                    <li><a href="{{ route('cashiermenu.index') }}" class="{{ $activePage === 'cashiermenu' ? 'active' : '' }}">Cashier Menu</a></li>
                </ul>
            </aside>

            <div class="main-content">
                <header class="topbar">
                    <div class="title">{{ $title ?? 'SIPOS' }}</div>
                    <div class="topbar-actions">
                        <label class="theme-switch" title="Toggle theme">
                            <span class="visually-hidden">Toggle theme</span>
                            <input id="theme-toggle" type="checkbox" aria-label="Toggle theme">
                            <span class="theme-slider"></span>
                        </label>
                        <span class="topbar-greeting">Hello, {{ auth()->user()->name }}</span>
                        <div class="profile-menu">
                            <button id="profile-button" class="profile-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="profile-dropdown">👤</button>
                            <div id="profile-dropdown" class="profile-dropdown" role="menu">
                                <a href="{{ route('profile') }}" role="menuitem">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" role="menuitem">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <section class="content">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </section>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
