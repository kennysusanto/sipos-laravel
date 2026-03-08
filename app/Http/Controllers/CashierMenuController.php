<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CashierMenuController extends Controller
{
    public function index(Request $request): View
    {
        $items = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->latest()
            ->get();

        return view('cashiermenu.index', [
            'items' => $items,
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'cart_payload' => ['required', 'string'],
            'table_id' => ['nullable', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $cartItems = json_decode($payload['cart_payload'], true);
        if (!is_array($cartItems) || empty($cartItems)) {
            return redirect()->route('cashiermenu.index', ['error' => 'Please select at least one menu item.']);
        }

        $availableItems = MenuItem::query()
            ->where('tenant_id', (int) $request->user()->tenant_id)
            ->get()
            ->keyBy('id');

        $selected = [];
        foreach ($cartItems as $cartItem) {
            $menuItemId = (int) ($cartItem['id'] ?? 0);
            $quantity = (int) ($cartItem['quantity'] ?? 0);

            if ($menuItemId <= 0 || $quantity <= 0 || !$availableItems->has($menuItemId)) {
                continue;
            }

            $selected[] = ['menu_item_id' => $menuItemId, 'quantity' => $quantity];
        }

        if (empty($selected)) {
            return redirect()->route('cashiermenu.index', ['error' => 'Selected items are invalid for your tenant.']);
        }

        $tableId = $payload['table_id'] ?? null;
        $note = $payload['note'] ?? null;

        $billId = DB::transaction(function () use ($selected, $tableId, $note) {
            $bill = Bill::query()->create(['table_id' => $tableId, 'note' => $note]);

            foreach ($selected as $item) {
                $menuItem = MenuItem::query()->find($item['menu_item_id']);

                if ($menuItem === null) {
                    throw new \RuntimeException('Menu item not found.');
                }

                if (($menuItem->stock - $item['quantity']) < 0) {
                    throw new \RuntimeException('Menu item stock cannot be less than zero.');
                }

                $menuItem->decrement('stock', $item['quantity']);
                BillItem::query()->create([
                    'bill_id' => $bill->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            return $bill->id;
        });

        return redirect()->route('bills.detail', ['bill' => $billId, 'status' => 'created']);
    }
}
