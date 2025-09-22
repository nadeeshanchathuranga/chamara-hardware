<?php

namespace App\Http\Controllers;

use App\Models\PaintProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaintProductController extends Controller
{
    public function index()
    {
        return PaintProduct::orderBy('name')->get(['id', 'name']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:paint_products,name'],
        ]);

        PaintProduct::create($data);

        return back()->with('success', 'Paint type added.');
    }

    public function update(Request $request, PaintProduct $paintProduct)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191', Rule::unique('paint_products','name')->ignore($paintProduct->id)],
        ]);

        $paintProduct->update($data);

        return back()->with('success', 'Paint type updated.');
    }

    public function destroy(PaintProduct $paintProduct)
    {
        $paintProduct->delete();

        return back()->with('success', 'Paint type deleted.');
    }
}
