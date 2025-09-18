<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $allStockTransactions = StockTransaction::with('product.supplier')->orderBy('created_at', 'desc')->get();


         return Inertia::render('StockTransaction/Index', [
             'allStockTransactions' => $allStockTransactions,
             'totalStockTransactions' => $allStockTransactions->count()
         ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */







     public function update(Request $request)
     {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }




         $Stockreason = StockTransaction::find($request->stock_id);

         if ($Stockreason != null)
         {
             $Stockreason->reason = $request->input('reason');



             $Stockreason->save();
             return back()
                 ->with('success', 'reason updated successfully !');
         }
         else
         {
             return back()
                 ->with('error', 'Could not find the reason');
         }
     }











    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockTransaction $stockTransaction)
    {
        //
    }
}
