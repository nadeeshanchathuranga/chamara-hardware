<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;



class SupplierController extends Controller
{

    public function index()
    {
        $allsuppliers = Supplier::orderBy('created_at', 'desc')->get();
        return Inertia::render('Suppliers/Index', [
            'allsuppliers' => $allsuppliers,
            'totalSuppliers' => $allsuppliers->count()
        ]);
    }

    // public function create()
    // {
    //     $categories = Category::all();

    //     return Inertia::render('Categories/Create', [
    //         'categories' => $categories,
    //     ]);
    // }

    public function store(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:191|regex:/^[a-zA-Z\s]+$/',
           'contact' => 'required|string|regex:/^\d{10}$/',
            'email' => 'required|email|regex:/^[\w\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,6}$/|max:255|unique:suppliers,email',
            'address' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);



        // if ($request->hasFile('image')) {
        //     $fileExtension = $request->file('image')->getClientOriginalExtension();
        //     $fileName = 'supplier' . date("YmdHis") . '.' . $fileExtension;
        //     $destinationPath = "images/uploads/supplier/";
        //     $request->file('image')->move(public_path($destinationPath), $fileName);
        //     $validated['image'] = $destinationPath . $fileName;
        // }

        if ($request->hasFile('image')) {
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'supplier_' . date("YmdHis") . '.' . $fileExtension;
            $path = $request->file('image')->storeAs('suppliers', $fileName, 'public');
            $validated['image'] = 'storage/' . $path;
        }

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->banner('Supplier created successfully.');
    }


    public function update(Request $request, Supplier $supplier)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'nullable|string|max:191',
            'contact' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $supplier->id,
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($supplier->image && Storage::disk('public')->exists(str_replace('storage/', '', $supplier->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $supplier->image));
            }

            // Save the new image
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'supplier_' . date("YmdHis") . '.' . $fileExtension;
            $path = $request->file('image')->storeAs('suppliers', $fileName, 'public');
            $validated['image'] = 'storage/' . $path;
        } else {
            // Retain the old image if no new image is uploaded
            $validated['image'] = $supplier->image;
        }


        $supplier->update($validated);


        // Redirect back with success message
        return redirect()->route('suppliers.index')->banner('Supplier updated successfully.');
    }





    public function destroy(Supplier $supplier)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        if ($supplier->image && Storage::disk('public')->exists(str_replace('storage/', '', $supplier->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $supplier->image));
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->banner('Supplier deleted successfully.');
    }
}
