<?php

namespace App\Http\Controllers;

use App\Models\ColoranceStock;
use App\Models\MachineStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MachineRefillController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required','array'],
            'items.*.id'    => ['required','integer','exists:colorance_stocks,id'],
            'items.*.units' => ['nullable','integer','min:0'],
        ]);

        $items = collect($data['items'])
            ->map(fn($i) => ['id' => (int)($i['id'] ?? 0), 'units' => (int)($i['units'] ?? 0)])
            ->filter(fn($i) => $i['units'] > 0)
            ->values();

        if ($items->isEmpty()) {
            return back()->with('info', 'Nothing to refill.');
        }

        DB::transaction(function () use ($items) {
            foreach ($items as $row) {
                $stock = ColoranceStock::lockForUpdate()->find($row['id']);
                if (!$stock) continue;

                if ($row['units'] > $stock->unit) {
                    throw ValidationException::withMessages([
                        "items.{$stock->id}.units" =>
                            "Not enough units in {$stock->name} (available {$stock->unit}).",
                    ]);
                }

                $stock->decrement('unit', $row['units']);

                MachineStock::create([
                    'colorance_stock_id' => $stock->id,
                    'units'              => $row['units'],
                ]);
            }
        });

        return back()->with('success', 'Refill recorded.');
    }
}
