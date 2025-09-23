<?php

namespace App\Http\Controllers;

use App\Models\BaseStock;
use App\Models\PaintProduct;
use App\Models\BaseType;
use App\Models\BaseStockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BaseStockController extends Controller
{
    public function index()
    {
        $baseStocks = BaseStock::with(['paintProduct', 'baseType'])
            ->orderBy('paint_product_id')
            ->orderBy('base_type_id')
            ->orderBy('can_size')
            ->get();

        return response()->json($baseStocks);
    }

    public function store(Request $request)
    {
        // Debug: Log the incoming request data
        \Log::info('Base Stock Store Request Data:', $request->all());
        
        $data = $request->validate([
            'paint_product_id' => 'required|exists:paint_products,id',
            'base_type_id' => 'required|exists:base_types,id',
            'can_size' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Normalize can_size to uppercase format
        $validCanSizes = ['1L', '4L', '10L'];
        $normalizedCanSize = strtoupper($data['can_size']);
        
        if (!in_array($normalizedCanSize, $validCanSizes)) {
            return response()->json([
                'message' => 'The selected can size is invalid. Valid options are: ' . implode(', ', $validCanSizes),
                'errors' => ['can_size' => ['The selected can size is invalid.']]
            ], 422);
        }
        
        $data['can_size'] = $normalizedCanSize;

        try {
            // Check if combination already exists
            $existing = BaseStock::where('paint_product_id', $data['paint_product_id'])
                ->where('base_type_id', $data['base_type_id'])
                ->where('can_size', $data['can_size'])
                ->first();

            if ($existing) {
                return response()->json([
                    'message' => 'This combination already exists. Please update the existing record instead.'
                ], 422);
            }

            $baseStock = BaseStock::create($data);
            $baseStock->load(['paintProduct', 'baseType']);

            return response()->json([
                'message' => 'Base stock created successfully',
                'data' => $baseStock
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to create base stock. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request, BaseStock $baseStock)
    {
        // Debug: Log the incoming request data
        \Log::info('Base Stock Update Request Data:', $request->all());
        
        $data = $request->validate([
            'paint_product_id' => 'required|exists:paint_products,id',
            'base_type_id' => 'required|exists:base_types,id',
            'can_size' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Normalize can_size to uppercase format
        $validCanSizes = ['1L', '4L', '10L'];
        $normalizedCanSize = strtoupper($data['can_size']);
        
        if (!in_array($normalizedCanSize, $validCanSizes)) {
            return response()->json([
                'message' => 'The selected can size is invalid. Valid options are: ' . implode(', ', $validCanSizes),
                'errors' => ['can_size' => ['The selected can size is invalid.']]
            ], 422);
        }
        
        $data['can_size'] = $normalizedCanSize;

        try {
            // Check if combination already exists (excluding current record)
            $existing = BaseStock::where('paint_product_id', $data['paint_product_id'])
                ->where('base_type_id', $data['base_type_id'])
                ->where('can_size', $data['can_size'])
                ->where('id', '!=', $baseStock->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'message' => 'This combination already exists with another record.'
                ], 422);
            }

            $baseStock->update($data);
            $baseStock->load(['paintProduct', 'baseType']);

            return response()->json([
                'message' => 'Base stock updated successfully',
                'data' => $baseStock
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to update base stock. Please try again.'
            ], 500);
        }
    }

    public function destroy(BaseStock $baseStock)
    {
        try {
            $baseStock->delete();

            return response()->json([
                'message' => 'Base stock deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unable to delete base stock. Please try again.'
            ], 500);
        }
    }

    public function getDropdownData()
    {
        $paintProducts = PaintProduct::select('id', 'name')->orderBy('name')->get();
        $baseTypes = BaseType::select('id', 'name')->orderBy('name')->get();
        $canSizes = ['1L', '4L', '10L'];

        return response()->json([
            'paintProducts' => $paintProducts,
            'baseTypes' => $baseTypes,
            'canSizes' => $canSizes,
        ]);
    }

    public function getTransactions(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $baseStockId = $request->get('base_stock_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = BaseStockTransaction::with([
            'baseStock.paintProduct:id,name',
            'baseStock.baseType:id,name',
            'paintOrder:id,product_name,can_size'
        ]);

        if ($baseStockId) {
            $query->where('base_stock_id', $baseStockId);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'data' => $transactions->items(),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ]
        ]);
    }

    public function downloadTransactionsPDF(Request $request)
    {
        $baseStockId = $request->get('base_stock_id');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $query = BaseStockTransaction::with([
            'baseStock.paintProduct:id,name',
            'baseStock.baseType:id,name',
            'paintOrder:id,product_name,can_size'
        ]);

        if ($baseStockId) {
            $query->where('base_stock_id', $baseStockId);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Generate HTML content for PDF
        $html = $this->generateTransactionsPDFHTML($transactions, $dateFrom, $dateTo, $baseStockId);

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="base-stock-transactions.html"');
    }

    private function generateTransactionsPDFHTML($transactions, $dateFrom = null, $dateTo = null, $baseStockId = null)
    {
        $baseStockName = '';
        if ($baseStockId) {
            $baseStock = BaseStock::with(['paintProduct', 'baseType'])->find($baseStockId);
            if ($baseStock) {
                $baseStockName = $baseStock->paintProduct->name . ' - ' . $baseStock->baseType->name . ' (' . $baseStock->can_size . ')';
            }
        }

        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Base Stock Transaction History</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .company-name { font-size: 24px; font-weight: bold; color: #059669; }
        .report-title { font-size: 18px; margin: 10px 0; }
        .filters { background: #f3f4f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters-title { font-weight: bold; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        th { background-color: #f9fafb; font-weight: bold; }
        .reduction { color: #dc2626; }
        .addition { color: #059669; }
        .adjustment { color: #2563eb; }
        .total-row { background-color: #f3f4f6; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #6b7280; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">JAAN Network (Pvt) Ltd</div>
        <div class="report-title">Base Stock Transaction History Report</div>
        <div>Generated on: ' . now()->format('F d, Y h:i A') . '</div>
    </div>';

        if ($dateFrom || $dateTo || $baseStockName) {
            $html .= '<div class="filters">
                <div class="filters-title">Applied Filters:</div>';
            
            if ($dateFrom) {
                $html .= '<div>From Date: ' . \Carbon\Carbon::parse($dateFrom)->format('F d, Y') . '</div>';
            }
            
            if ($dateTo) {
                $html .= '<div>To Date: ' . \Carbon\Carbon::parse($dateTo)->format('F d, Y') . '</div>';
            }
            
            if ($baseStockName) {
                $html .= '<div>Base Stock Item: ' . $baseStockName . '</div>';
            }
            
            $html .= '</div>';
        }

        $html .= '<table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Product Details</th>
                    <th>Transaction Type</th>
                    <th>Quantity Before</th>
                    <th>Quantity After</th>
                    <th>Change</th>
                    <th>Order #</th>
                    <th>Performed By</th>
                </tr>
            </thead>
            <tbody>';

        $totalReductions = 0;
        $totalAdditions = 0;

        foreach ($transactions as $transaction) {
            $typeClass = match($transaction->transaction_type) {
                'reduction' => 'reduction',
                'addition' => 'addition',
                'adjustment' => 'adjustment',
                default => ''
            };

            $typeIcon = match($transaction->transaction_type) {
                'reduction' => '↓',
                'addition' => '↑',
                'adjustment' => '~',
                default => '-'
            };

            if ($transaction->transaction_type === 'reduction') {
                $totalReductions += $transaction->quantity_changed;
            } elseif ($transaction->transaction_type === 'addition') {
                $totalAdditions += $transaction->quantity_changed;
            }

            $html .= '<tr>
                <td>' . $transaction->created_at->format('M d, Y h:i A') . '</td>
                <td>' . 
                    ($transaction->baseStock->paintProduct->name ?? 'N/A') . ' - ' .
                    ($transaction->baseStock->baseType->name ?? 'N/A') . ' (' .
                    ($transaction->baseStock->can_size ?? 'N/A') . ')' .
                '</td>
                <td class="' . $typeClass . '">' . $typeIcon . ' ' . ucfirst($transaction->transaction_type) . '</td>
                <td>' . number_format($transaction->quantity_before, 2) . '</td>
                <td>' . number_format($transaction->quantity_after, 2) . '</td>
                <td class="' . $typeClass . '">' . 
                    ($transaction->transaction_type === 'reduction' ? '-' : '+') . 
                    number_format(abs($transaction->quantity_changed), 2) . 
                '</td>
                <td>' . ($transaction->paint_order_id ? '#' . $transaction->paint_order_id : 'Manual') . '</td>
                <td>' . ($transaction->performed_by ?: 'System') . '</td>
            </tr>';
        }

        if ($transactions->count() > 0) {
            $html .= '<tr class="total-row">
                <td colspan="5"><strong>Summary</strong></td>
                <td><strong>Total Reductions: -' . number_format($totalReductions, 2) . '<br>
                Total Additions: +' . number_format($totalAdditions, 2) . '</strong></td>
                <td colspan="2"><strong>Net Change: ' . 
                    number_format($totalAdditions - $totalReductions, 2) . '</strong></td>
            </tr>';
        } else {
            $html .= '<tr><td colspan="8" style="text-align: center; padding: 20px;">No transactions found for the selected criteria.</td></tr>';
        }

        $html .= '</tbody>
        </table>
        
        <div class="footer">
            <div>Total Records: ' . $transactions->count() . '</div>
            <div>Report generated by Chamara Hardware Management System</div>
        </div>
        
        <script>
            // Auto-print when opened
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        </script>
    </body>
    </html>';

        return $html;
    }
}
