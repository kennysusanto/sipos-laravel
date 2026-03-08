<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function index(Request $request): View
    {
        $tenants = Tenant::query()->latest()->get();

        return view('tenants.index', [
            'tenants' => $tenants,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }

    public function create(): View
    {
        return view('tenants.create');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $sameNameTenant = Tenant::withTrashed()->where('name', $request['name'])->first();
            if ($sameNameTenant) {
                return redirect()->back()->withInput()->with('error', 'Tenant name already exists.');
            }

            $payload = $request->validate([
                'name' => ['required', 'string', 'max:100', Rule::unique('tenants', 'name')->whereNull('deleted_at')],
                'display_name' => ['required', 'string', 'max:150'],
            ]);

            $createdTenant = Tenant::query()->create($payload);

            User::query()->create([
                'tenant_id' => $createdTenant->id,
                'name' => 'admin',
                'email' => fake()->unique()->safeEmail(),
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);

            return redirect()->route('tenants.index', ['status' => 'created']);
        } catch (\Throwable $exception) {
            // log $exception->getMessage() todo
            return redirect()->back()->withInput()->with('error', 'Failed to create tenant.');
        }
    }

    public function edit(Tenant $tenant): View
    {
        return view('tenants.edit', ['tenant' => $tenant]);
    }

    public function detail(Request $request, Tenant $tenant): View
    {
        $users = User::query()
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->get();

        return view('tenants.detail', [
            'tenant' => $tenant,
            'users' => $users,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $payload = $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('tenants', 'name')->whereNull('deleted_at')->ignore($tenant->id),
            ],
            'display_name' => ['required', 'string', 'max:150'],
        ]);

        $tenant->update($payload);

        return redirect()->route('tenants.index', ['status' => 'updated']);
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        if ($tenant->users()->exists()) {
            return redirect()->route('tenants.index', ['error' => 'Cannot delete tenant with active users.']);
        }

        $tenant->delete();

        return redirect()->route('tenants.index', ['status' => 'deleted']);
    }
}
