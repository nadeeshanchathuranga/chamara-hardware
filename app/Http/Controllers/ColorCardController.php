<?php

namespace App\Http\Controllers;

use App\Models\ColorCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorCardController extends Controller
{
    public function index()
    {
        return ColorCard::orderBy('name')->get(['id', 'name']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:color_cards,name'],
        ]);

        ColorCard::create($data);

        return back()->with('success', 'Color card added.');
    }

    public function update(Request $request, ColorCard $colorCard)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191', Rule::unique('color_cards','name')->ignore($colorCard->id)],
        ]);

        $colorCard->update($data);

        return back()->with('success', 'Color card updated.');
    }

    public function destroy(ColorCard $colorCard)
    {
        $colorCard->delete();

        return back()->with('success', 'Color card deleted.');
    }
}

