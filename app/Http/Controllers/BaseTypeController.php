<?php

namespace App\Http\Controllers;

use App\Models\BaseType;
use Illuminate\Http\Request;

class BaseTypeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:base_types,name'],
        ]);

        BaseType::create($data);

        return back()->with('success', 'Base type added.');
    }
}
