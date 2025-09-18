<?php

namespace App\Http\Controllers;

use App\Models\ColorCard;
use Illuminate\Http\Request;

class ColorCardController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:color_cards,name'],
        ]);

        ColorCard::create($data);

        return back()->with('success', 'Color card added.');
    }
}

