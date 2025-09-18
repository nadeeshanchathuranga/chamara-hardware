<?php

namespace App\Http\Controllers;

use App\Models\PaintProduct;
use Illuminate\Http\Request;

class PaintProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:paint_products,name'],
        ]);

        PaintProduct::create($data);

        return back()->with('success', 'Paint type added.');
    }
}
