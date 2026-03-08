@extends('layouts.app', ['title' => 'Menu Items'])

@section('content')
<h1 class="page-title">Menu Items</h1>
<p class="page-subtitle">Manage product cards for your catalog.</p>

<div class="page-header-actions">
    <a href="{{ route('menuitems.create') }}" class="btn btn-primary">Create Menu Item</a>
</div>

@if($items->isEmpty())
    <div class="dashboard-card">
        <div class="card-title">No menu items found</div>
        <div class="card-value card-value-sm">Create your first menu item to populate this section.</div>
    </div>
@else
    <div class="menu-grid">
        @foreach($items as $item)
            <article class="menu-card">
                @if(empty($item->url))
                    <div class="menu-card-image">
                        <div class="menu-card-image-placeholder">Image</div>
                    </div>
                @else
                    <div class="menu-card-image">
                        <img src="{{ $item->url }}" alt="{{ $item->display_name }}">
                    </div>
                @endif

                <div class="menu-card-content">
                    <h3>{{ $item->display_name }}</h3>
                    <p>{{ $item->description }}</p>
                    <div class="menu-card-price">{{ number_format($item->price, 2) }}</div>
                    <div class="menu-card-meta">Stock: {{ $item->stock }}</div>
                </div>

                <div class="menu-card-actions">
                    <a href="{{ route('menuitems.edit', $item) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('menuitems.destroy', $item) }}" onsubmit="return confirm('Delete this menu item?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
