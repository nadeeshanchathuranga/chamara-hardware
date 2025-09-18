<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

use App\Models\Customer;
use App\Models\PaintOrder;
use App\Models\PaintProduct;
use App\Models\ColorCard;
use App\Models\BaseType;
use App\Models\Report;

// POS models
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Employee;

class PaintOrderController extends Controller
{
    /** List orders + dropdown data */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $query = PaintOrder::with([
            'customer:id,name',
            'paintProduct:id,name',
            'colorCard:id,name',
            'baseType:id,name',
        ]);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('paintProduct', function ($paintQuery) use ($search) {
                    $paintQuery->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('colorCard', function ($colorQuery) use ($search) {
                    $colorQuery->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('can_size', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($status && in_array($status, ['pending', 'completed'])) {
            $query->where('status', $status);
        }

        return Inertia::render('Paint/OrdersIndex', [
            'orders' => fn () => $query
                ->latest()
                ->get([
                    'id','customer_id','paint_product_id','color_card_id','base_type_id',
                    'can_size','quantity','unit_price','status','created_at'
                ])
                ->map(function ($o) {
                    return [
                        'id'            => $o->id,
                        'customer'      => ['id' => $o->customer_id,       'name' => optional($o->customer)->name],
                        'paint_product' => ['id' => $o->paint_product_id,   'name' => optional($o->paintProduct)->name],
                        'color_card'    => ['id' => $o->color_card_id,      'name' => optional($o->colorCard)->name],
                        'base_type'     => ['id' => $o->base_type_id,       'name' => optional($o->baseType)->name],
                        'can_size'      => $o->can_size,
                        'quantity'      => $o->quantity,
                        'unit_price'    => $o->unit_price, // COST
                        'status'        => $o->status,
                        'created_at'    => $o->created_at,
                    ];
                }),

            'filters' => [
                'search' => $search,
                'status' => $status,
            ],

            'paintTypes'   => fn () => PaintProduct::orderBy('name')->get(['id','name']),
            'colorCards'   => fn () => ColorCard::orderBy('name')->get(['id','name']),
            'baseTypes'    => fn () => BaseType::orderBy('name')->get(['id','name']),
            'customers'    => fn () => Customer::orderBy('name')->get(['id','name','email','phone']),
            'loggedInUser' => Auth::user(),
            'companyInfo'  => fn () => \App\Models\CompanyInfo::first(),
        ]);
    }

    /** Store order (unit_price = COST) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required','string','max:191'],
            'phone'         => ['nullable','string','max:50'],
            'email'         => ['nullable','email','max:191'],

            'paint_type_id' => ['required','exists:paint_products,id'],
            'color_card_id' => ['required','exists:color_cards,id'],
            'base_type_id'  => ['required','exists:base_types,id'],
            'can_size'      => ['required','in:1L,4L,10L'],

            'quantity'      => ['required','integer','min:1'],
            'unit_price'    => ['required','numeric','min:0'], // COST
            'status'        => ['nullable','in:pending,completed'],
        ]);

        // find/create customer
        $customer = null;
        if (!empty($data['email'])) {
            $customer = Customer::where('email', $data['email'])->first();
        }
        if (!$customer && !empty($data['phone'])) {
            $customer = Customer::where('phone', $data['phone'])->first();
        }
        if (!$customer) {
            $customer = Customer::create([
                'name'           => $data['customer_name'],
                'email'          => $data['email'] ?? null,
                'phone'          => $data['phone'] ?? null,
                'member_since'   => Carbon::today(),
                'loyalty_points' => 0,
            ]);
        } else {
            if (!empty($data['customer_name']) && $customer->name !== $data['customer_name']) {
                $customer->update(['name' => $data['customer_name']]);
            }
        }

        // save order (unit_price = COST)
        PaintOrder::create([
            'customer_id'      => $customer->id,
            'paint_product_id' => $data['paint_type_id'],
            'color_card_id'    => $data['color_card_id'],
            'base_type_id'     => $data['base_type_id'],
            'can_size'         => $data['can_size'],
            'quantity'         => $data['quantity'],
            'unit_price'       => $data['unit_price'], // COST
            'status'           => $data['status'] ?? 'pending',
        ]);

        return redirect()->route('paints.orders.index')->with('success', 'Order saved.');
    }

    /**
     * Pay: converts order -> sale using SELLING price.
     * - SaleItem.unit_price = selling price
     * - Sale.total_amount   = selling price * qty
     * - Sale.total_cost     = order.unit_price (cost) * qty
     */
    public function pay(Request $request, PaintOrder $order)
    {
        $data = $request->validate([
            'quantity'       => ['required','integer','min:1'],
            'selling_price'  => ['required','numeric','min:0'],
            'cash'           => ['nullable','numeric','min:0'],
            'payment_method' => ['required','in:cash,card'],
        ]);

        try {
            return DB::transaction(function () use ($data, $order) {
                $qty        = (int) $data['quantity'];
                $sell       = (float) $data['selling_price'];
                $cost       = (float) $order->unit_price; // stored cost
                $total      = $qty * $sell;
                $totalCost  = $qty * $cost;

                // ensure a generic product exists
                $sku  = 'PAINT-CUSTOM';
                $name = 'Custom Paint Mix';
                $genericProduct = Product::where('code', $sku)->first();
                if (!$genericProduct) {
                    $genericProduct = Product::firstOrNew(['code' => $sku]);
                    if (!$genericProduct->exists) {
                        $genericProduct->forceFill([
                            'name'           => $name,
                            'barcode'        => $sku,
                            'selling_price'  => 0,
                            'cost_price'     => 0,
                            'stock_quantity' => 0,
                        ])->save();
                    }
                } else {
                    $genericProduct->forceFill([
                        'barcode'        => $genericProduct->barcode ?: $sku,
                        'selling_price'  => $genericProduct->selling_price ?? 0,
                        'cost_price'     => $genericProduct->cost_price ?? 0,
                        'stock_quantity' => $genericProduct->stock_quantity ?? 0,
                    ])->save();
                }

                $userId     = optional(Auth::user())->id ?? 1;     // ensure exists if NOT NULL
                $employeeId = Employee::value('id');                // null okay if column nullable

                $sale = Sale::create([
                    'customer_id'    => $order->customer_id,
                    'employee_id'    => $employeeId,
                    'user_id'        => $userId,
                    'order_id'       => 'PO-'.$order->id,
                    'total_amount'   => $total,
                    'discount'       => 0,
                    'total_cost'     => $totalCost, // record cost
                    'payment_method' => $data['payment_method'],
                    'sale_date'      => now()->toDateString(),
                    'cash'           => $data['cash'] ?? 0,
                    'custom_discount'=> 0,
                ]);

                SaleItem::create([
                    'sale_id'     => $sale->id,
                    'product_id'  => $genericProduct->id,
                    'quantity'    => $qty,
                    'unit_price'  => $sell,   // SELLING price on the bill
                    'total_price' => $total,
                ]);

                $order->update(['status' => 'completed']);

                // Create paint order report entry
                Report::create([
                    'type' => 'Paint Orders',
                    'user_id' => $userId,
                    'generated_at' => now()->toDateString(),
                    'details' => json_encode([
                        'order_id' => $order->id,
                        'sale_id' => $sale->id,
                        'customer_name' => optional($order->customer)->name,
                        'paint_product' => optional($order->paintProduct)->name,
                        'color_card' => optional($order->colorCard)->name,
                        'base_type' => optional($order->baseType)->name,
                        'can_size' => $order->can_size,
                        'quantity' => $qty,
                        'unit_cost' => $cost,
                        'selling_price' => $sell,
                        'total_amount' => $total,
                        'profit' => $total - $totalCost,
                        'payment_method' => $data['payment_method'],
                        'sale_date' => now()->toDateString(),
                    ]),
                ]);

                return response()->json(['sale_id' => $sale->id], 201);
            });
        } catch (Throwable $e) {
            Log::error('Order pay failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to complete payment.',
                'hint'    => 'Verify required columns on sales/sale_items and defaults.',
                'error'   => $e->getMessage(),
            ], 422);
        }
    }
}
