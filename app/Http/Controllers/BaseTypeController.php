<?php

namespace App\Http\Controllers;

use App\Models\BaseType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BaseTypeController extends Controller
{
    public function index()
    {
        return BaseType::orderBy('name')->get(['id', 'name']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191','unique:base_types,name'],
        ]);

        BaseType::create($data);

        return back()->with('success', 'Base type added.');
    }

    public function update(Request $request, BaseType $baseType)
    {
        $data = $request->validate([
            'name' => ['required','string','max:191', Rule::unique('base_types','name')->ignore($baseType->id)],
        ]);

        $baseType->update($data);

        return back()->with('success', 'Base type updated.');
    }

    public function destroy(BaseType $baseType)
    {
        $baseType->delete();

        return back()->with('success', 'Base type deleted.');
    }
}
