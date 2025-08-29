<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quotation;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Models\CompanyInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 

        if (!Gate::allows('hasRole', ['Admin', 'Cashier'])) {
            abort(403, 'Unauthorized');
        }

        $allcategories = Category::with('parent')->get()->map(function ($category) {
            $category->hierarchy_string = $category->hierarchy_string; // Access it
            return $category;
        });
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $allemployee = Employee::orderBy('created_at', 'desc')->get();
        $companyInfo = CompanyInfo::first();
        


        // Render the page for GET requests
        return Inertia::render('Quotations/Index', [
            'allcategories' => $allcategories,
            'colors' => $colors,
            'sizes' => $sizes,
            'companyInfo' => $companyInfo,
            'loggedInUser' => Auth::user(),
        ]);
        
    }
    public function getProduct(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin', 'Cashier'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'barcode' => 'required',
        ]);

        $product = Product::where('barcode', $request->barcode)
            ->orWhere('code', $request->barcode)
            ->first();

        return response()->json([
            'product' => $product,
            'error' => $product ? null : 'Product not found',
        ]);
    }

    public function saveQuotationPdf(Request $request)
{
    $request->validate([
        'pdf' => 'required|file|max:2048', 
        'order_id' => 'required|string',
    ]);

    try {
       
        $path = $request->file('pdf')->store('public/quotations');

        // Extract the file path (relative to storage)
        $relativePath = Storage::url($path);

        // Save the file path and order ID in the database
        \DB::table('quotations')->insert([
            'order_id' => $request->input('order_id'),
            'file_path' => $relativePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'PDF saved successfully!', 'file_path' => $relativePath], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to save PDF.', 'error' => $e->getMessage()], 500);
    }
}
    
}
