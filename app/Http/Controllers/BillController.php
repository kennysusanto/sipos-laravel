<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillController extends Controller
{
    public function index(Request $request): View
    {
        $bills = Bill::query()->latest()->get();

        return view('bills.index', [
            'bills' => $bills,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }

    public function create(): View
    {
        return view('bills.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'table_id' => ['nullable', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        Bill::query()->create($payload);

        return redirect()->route('bills.index', ['status' => 'created']);
    }

    public function edit(Bill $bill): View
    {
        return view('bills.edit', ['bill' => $bill]);
    }

    public function update(Request $request, Bill $bill): RedirectResponse
    {
        $payload = $request->validate([
            'table_id' => ['nullable', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $bill->update($payload);

        return redirect()->route('bills.index', ['status' => 'updated']);
    }

    public function destroy(Bill $bill): RedirectResponse
    {
        $bill->delete();

        return redirect()->route('bills.index', ['status' => 'deleted']);
    }

    public function detail(Bill $bill, Request $request): View
    {
        $bill->load(['items.menuItem']);

        return view('billitems.index', [
            'bill' => $bill,
            'items' => $bill->items,
            'status' => $request->query('status'),
            'error' => $request->query('error'),
        ]);
    }
}
