<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillItemController extends Controller
{
    public function create(Bill $bill, Request $request): View
    {
        $menuItems = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->latest()
            ->get();

        return view('billitems.create', [
            'bill' => $bill,
            'menuItems' => $menuItems,
        ]);
    }

    public function store(Bill $bill, Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'menu_item_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $menuItem = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->find($payload['menu_item_id']);

        if (!$menuItem) {
            return redirect()->route('billitems.create', ['bill' => $bill->id])->withErrors([
                'menu_item_id' => 'Selected menu item is invalid for your tenant.',
            ]);
        }

        // MenuItem::query()->where('id', $menuItem->id)->decrement('stock', $payload['quantity']);
        $menuItem->decrement('stock', $payload['quantity']);

        BillItem::query()->create([
            'bill_id' => $bill->id,
            'menu_item_id' => $menuItem->id,
            'quantity' => $payload['quantity'],
        ]);

        return redirect()->route('bills.detail', ['bill' => $bill->id, 'status' => 'created']);
    }

    public function edit(BillItem $billitem, Request $request): View
    {
        $billitem->load('bill');

        $menuItems = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->latest()
            ->get();

        return view('billitems.edit', [
            'billItem' => $billitem,
            'bill' => $billitem->bill,
            'menuItems' => $menuItems,
        ]);
    }

    public function update(BillItem $billitem, Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'menu_item_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $menuItem = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->find($payload['menu_item_id']);

        if (!$menuItem) {
            return redirect()->route('billitems.edit', ['billitem' => $billitem->id])->withErrors([
                'menu_item_id' => 'Selected menu item is invalid for your tenant.',
            ]);
        }

        $billitem->update([
            'menu_item_id' => $menuItem->id,
            'quantity' => $payload['quantity'],
        ]);

        return redirect()->route('bills.detail', ['bill' => $billitem->bill_id, 'status' => 'updated']);
    }

    public function destroy(BillItem $billitem): RedirectResponse
    {
        $billId = $billitem->bill_id;
        $billitem->delete();

        return redirect()->route('bills.detail', ['bill' => $billId, 'status' => 'deleted']);
    }
}
