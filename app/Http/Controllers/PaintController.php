<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ColoranceStock;
use App\Models\MachineStock;


class PaintController extends Controller
{
 

    public function index()
    {
        // Get paint order sales data from reports with pagination
        $perPage = 10; // Show 10 orders per page
        $page = request()->get('page', 1);
        
        $paintOrderReportsQuery = \App\Models\Report::where('type', 'Paint Orders')
            ->orderBy('generated_at', 'desc');
        
        // Get total count for pagination info
        $totalOrders = $paintOrderReportsQuery->count();
        
        // Get paginated reports
        $paintOrderReports = $paintOrderReportsQuery
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();
        
        // Process paint order data
        $paintOrderSummary = [
            'total_orders' => $totalOrders,
            'total_amount' => 0,
            'total_profit' => 0,
            'total_cost' => 0,
        ];
        
        $paintOrderDetails = [];
        
        foreach ($paintOrderReports as $report) {
            $details = json_decode($report->details, true);
            if ($details) {
                $paintOrderSummary['total_amount'] += $details['total_amount'] ?? 0;
                $paintOrderSummary['total_profit'] += $details['profit'] ?? 0;
                $paintOrderSummary['total_cost'] += ($details['unit_cost'] * $details['quantity']) ?? 0;
                
                $paintOrderDetails[] = array_merge($details, [
                    'report_id' => $report->id,
                    'generated_at' => $report->generated_at,
                ]);
            }
        }

        // Calculate pagination info
        $lastPage = ceil($totalOrders / $perPage);
        $pagination = [
            'current_page' => (int) $page,
            'per_page' => $perPage,
            'total' => $totalOrders,
            'last_page' => $lastPage,
            'from' => ($page - 1) * $perPage + 1,
            'to' => min($page * $perPage, $totalOrders),
        ];

        return Inertia::render('Paint/Index', [
            'coloranceStocks' => ColoranceStock::orderBy('name')
                ->get(['id', 'name', 'can_size', 'unit']),
            'machineHistory' => MachineStock::with(['colorance:id,name,can_size'])
                ->latest()->take(25)
                ->get(['id', 'colorance_stock_id', 'units', 'created_at']),
            'paintTypes' => \App\Models\PaintProduct::orderBy('name')->get(['id', 'name']),
            'colorCards' => \App\Models\ColorCard::orderBy('name')->get(['id', 'name']),
            'baseTypes' => \App\Models\BaseType::orderBy('name')->get(['id', 'name']),
            // Low stock alerts
            'lowColoranceStocks' => ColoranceStock::where('unit', '<=', 5)->get(['id', 'name', 'can_size', 'unit']),
            'lowBaseStocks' => \App\Models\BaseStock::where('quantity', '<=', 5)
                ->with(['paintProduct:id,name', 'baseType:id,name'])
                ->get(['id', 'paint_product_id', 'base_type_id', 'can_size', 'quantity']),
            // Paint order sales data with pagination
            'paintOrderSummary' => $paintOrderSummary,
            'paintOrderDetails' => $paintOrderDetails,
            'paintOrderPagination' => $pagination,
        ]);
    }

}