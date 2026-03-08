<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $tenantId = (int) $request->session()->get('tenant_id', 0);
        $users = User::query()->with('tenant')->where('tenant_id', $tenantId)->latest()->get();

        return view('users.index', [
            'users' => $users,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }

    public function create(): View
    {
        return view('users.create', [
            'tenants' => Tenant::query()->orderBy('display_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => ['required', 'string', 'min:4'],
        ]);

        User::query()->create([
            ...$payload,
            'password' => Hash::make($payload['password']),
        ]);

        return redirect()->route('users.index', ['status' => 'created']);
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'tenants' => Tenant::query()->orderBy('display_name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $payload = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        if (!empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            unset($payload['password']);
        }

        $user->update($payload);

        return redirect()->route('users.index', ['status' => 'updated']);
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()?->id === $user->id) {
            return redirect()->route('users.index', ['error' => 'You cannot delete your own account.']);
        }

        $isOnlyAdmin = $user->role === 'admin' && User::query()->where('role', 'admin')->where('tenant_id', $user->tenant_id)->whereNull('deleted_at')->count() === 1;
        if ($isOnlyAdmin) {
            return redirect()->route('users.index', ['error' => 'Cannot delete the only admin user. Please assign another user as admin before deleting this user.']);
        }

        $user->delete();

        return redirect()->route('users.index', ['status' => 'deleted']);
    }
}
