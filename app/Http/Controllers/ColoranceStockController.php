<?php

namespace App\Http\Controllers;

use App\Models\ColoranceStock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColoranceStockController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'can_size' => ['required', 'string', 'max:20'], // e.g. 1L, 500ml
            'unit' => ['required', 'integer', 'min:0'], // stock qty
        ]);

        ColoranceStock::create($data);

        return back()->with('success', 'Colorance stock created.');
    }

    public function update(Request $request, ColoranceStock $coloranceStock)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'can_size' => ['required', 'string', 'max:20'],
            'unit' => ['required', 'integer', 'min:0'],
        ]);

        $coloranceStock->update($data);

        return back()->with('success', 'Colorance stock updated.');
    }

    public function destroy(ColoranceStock $coloranceStock)
    {
        $coloranceStock->delete();

        return back()->with('success', 'Colorance stock deleted.');
    }
}
