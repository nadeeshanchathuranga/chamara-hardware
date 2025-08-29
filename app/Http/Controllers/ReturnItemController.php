<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ReturnItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('hasRole', ['Admin', 'Manager'])) {
            abort(403, 'Unauthorized');
        }

        $sales = Sale::with('customer')->orderBy('created_at', 'desc')->get();
        $saleItems  = SaleItem::with('product')->orderBy('created_at', 'desc')->get();




        return Inertia::render('ReturnItem/Index', [
            'sales' => $sales,
            'saleItems' => $saleItems,

        ]);
    }

    public function fetchSaleItems(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
        ]);

        $saleItems = SaleItem::with('product') // Load the related product
            ->where('sale_id', $request->input('sale_id'))
            ->get();

        return response()->json($saleItems);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */




    public function store(Request $request)
    {
        // Debug the incoming data
        if ($request->isJson()) {
            $data = $request->json()->all();
            dd($data); // Inspect the parsed data
        }

        // If data is not JSON, inspect it in other formats
        // dd($request->all());
    }





    /**
     * Display the specified resource.
     */
    public function show(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnItem $returnItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturnItem $returnItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnItem $returnItem)
    {
        //
    }
}
