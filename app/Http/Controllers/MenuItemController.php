<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(Request $request): View
    {
        $tenantId = (int) $request->user()->tenant_id;
        $items = MenuItem::query()->where('tenant_id', $tenantId)->latest()->get();

        return view('menuitems.index', [
            'items' => $items,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }

    public function create(): View
    {
        return view('menuitems.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $tenantId = (int) $request->user()->tenant_id;

        $payload = $request->validate([
            'display_name' => ['required', 'string', 'max:150'],
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('menu_items', 'name')->where(fn ($query) => $query->where('tenant_id', $tenantId)->whereNull('deleted_at')),
            ],
            'url' => ['nullable', 'url', 'max:500'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        MenuItem::query()->create([
            ...$payload,
            'tenant_id' => $tenantId,
        ]);

        return redirect()->route('menuitems.index', ['status' => 'created']);
    }

    public function edit(MenuItem $menuitem, Request $request): View
    {
        abort_if($menuitem->tenant_id !== (int) $request->user()->tenant_id, 403);

        return view('menuitems.edit', ['item' => $menuitem]);
    }

    public function update(Request $request, MenuItem $menuitem): RedirectResponse
    {
        $tenantId = (int) $request->user()->tenant_id;
        abort_if($menuitem->tenant_id !== $tenantId, 403);

        $payload = $request->validate([
            'display_name' => ['required', 'string', 'max:150'],
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('menu_items', 'name')->where(fn ($query) => $query->where('tenant_id', $tenantId)->whereNull('deleted_at'))->ignore($menuitem->id),
            ],
            'url' => ['nullable', 'url', 'max:500'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $menuitem->update($payload);

        return redirect()->route('menuitems.index', ['status' => 'updated']);
    }

    public function destroy(Request $request, MenuItem $menuitem): RedirectResponse
    {
        abort_if($menuitem->tenant_id !== (int) $request->user()->tenant_id, 403);

        $menuitem->delete();

        return redirect()->route('menuitems.index', ['status' => 'deleted']);
    }
}
