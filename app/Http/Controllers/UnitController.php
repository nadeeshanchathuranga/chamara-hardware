<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }

       $allunits = Unit::orderBy('created_at', 'desc')->get(); 

        return Inertia::render('Unit/Index', [
            'allunits' => $allunits,
            'totalUnits' => $allunits->count(),
        ]);
    }

    public function store(Request $request)
    {


        if ($request->has('unitName')) {

            $request->merge(['name' => $request->input('unitName')]);


            $validated = $request->validate([
                'name' => 'required|string|max:191|regex:/^[a-zA-Z\s]+$/',
            ]);


            Unit::create($validated);
            return redirect()
            ->route('units.index')
            ->with('success', 'Unit created successfully and redirected to Units.');
        }

        if ($request->has('name')) {
            // Validate name directly
            $validated = $request->validate([
                'name' => 'required|string|max:191|regex:/^[a-zA-Z\s]+$/',
            ]);


            Unit::create($validated);


            return redirect()->route('units.index')->banner('Unit created successfully !');
        }

        return redirect()->back()->withErrors(['error' => 'Invalid data provided.']);
    }

    public function update(Request $request, Unit $unit)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        $validated = $request->validate([
            'name' => 'nullable|string|max:191|regex:/^[a-zA-Z\s]+$/',
        ]);

        $unit->update($validated);

        return redirect()->route('units.index')->banner('Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        if (!Gate::allows('hasRole', ['Admin','Manager'])) {
            abort(403, 'Unauthorized');
        }
        $unit->delete();
        return redirect()->route('units.index')->banner('Unit Deleted successfully.');
    }

}
