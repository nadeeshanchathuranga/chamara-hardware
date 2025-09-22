<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ColoranceStock;
use App\Models\MachineStock;


class PaintController extends Controller
{
 

    public function index()
    {
        return Inertia::render('Paint/Index', [
            'coloranceStocks' => ColoranceStock::orderBy('name')
                ->get(['id', 'name', 'can_size', 'unit']),
            'machineHistory' => MachineStock::with(['colorance:id,name,can_size'])
                ->latest()->take(25)
                ->get(['id', 'colorance_stock_id', 'units', 'created_at']),
            'paintTypes' => \App\Models\PaintProduct::orderBy('name')->get(['id', 'name']),
            'colorCards' => \App\Models\ColorCard::orderBy('name')->get(['id', 'name']),
            'baseTypes' => \App\Models\BaseType::orderBy('name')->get(['id', 'name']),
        ]);
    }

}