<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use App\Traits\GeneratesUniqueCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use GeneratesUniqueCode;

    public function test(Request $request)
    {
        $allcategories = Category::with('parent')->get()->map(function ($category) {
            $category->hierarchy_string = $category->hierarchy_string; // Access it
            return $category;
        });
        return Inertia::render('Products/index2', [
            'categories' => $allcategories
        ]);
    }

    public function fetchProducts(Request $request)
    {
        $query = $request->input('search');
        $sortOrder = $request->input('sort');
        $selectedColor = $request->input('color');
        $selectedSize = $request->input('size');
        $stockStatus = $request->input('stockStatus');
        $selectedCategory = $request->input('selectedCategory');

        $productsQuery = Product::with('category', 'color', 'size', 'supplier')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($subQuery) use ($query) {
                    $subQuery->where('name', 'like', "%{$query}%")
                        ->orWhere('code', 'like', "%{$query}%");
                });
            })
            ->when($selectedColor, function ($queryBuilder) use ($selectedColor) {
                $queryBuilder->whereHas('color', function ($colorQuery) use ($selectedColor) {
                    $colorQuery->where('name', $selectedColor);
                });
            })
            ->when($selectedSize, function ($queryBuilder) use ($selectedSize) {
                $queryBuilder->whereHas('size', function ($sizeQuery) use ($selectedSize) {
                    $sizeQuery->where('name', $selectedSize);
                });
            })
            ->when(in_array($sortOrder, ['asc', 'desc']), function ($queryBuilder) use ($sortOrder) {
                $queryBuilder->orderBy('selling_price', $sortOrder);
            })
            ->when($stockStatus, function ($queryBuilder) use ($stockStatus) {
                if ($stockStatus === 'in') {
                    $queryBuilder->where('stock_quantity', '>', 0);
                } elseif ($stockStatus === 'out') {
                    $queryBuilder->where('stock_quantity', '<=', 0);
                }
            })
            ->when($selectedCategory, function ($queryBuilder) use ($selectedCategory) {
                $queryBuilder->where('category_id', $selectedCategory);
            });

        $products = $productsQuery->orderBy('created_at', 'desc')->paginate(8);

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * Display a listing of the resource.
     */

   public function index(Request $request)
    {
        // Inputs
        $search           = trim((string) $request->input('search', ''));
        $sortOrder        = $request->input('sort');             // 'asc' | 'desc'
        $selectedColor    = $request->input('color');            // color name
        $selectedSize     = $request->input('size');             // size name
        $stockStatus      = $request->input('stockStatus');      // 'in' | 'out'
        $selectedCategory = $request->input('selectedCategory'); // category id

        $productsQuery = Product::query()
            ->with(['category', 'color', 'size', 'supplier'])
            // 🔍 Search only by product code
            ->search($search)
            // Category filter
            ->when($selectedCategory, function ($q) use ($selectedCategory) {
                $q->where('category_id', $selectedCategory);
            })
            // Stock filter
            ->when($stockStatus === 'in', function ($q) {
                $q->where('stock_quantity', '>', 0);
            })
            ->when($stockStatus === 'out', function ($q) {
                $q->where('stock_quantity', '<=', 0);
            })
            // Color filter
            ->when($selectedColor, function ($q) use ($selectedColor) {
                $q->whereHas('color', function ($c) use ($selectedColor) {
                    $c->where('name', $selectedColor);
                });
            })
            // Size filter
            ->when($selectedSize, function ($q) use ($selectedSize) {
                $q->whereHas('size', function ($s) use ($selectedSize) {
                    $s->where('name', $selectedSize);
                });
            });

        // Count BEFORE pagination
        $count = (clone $productsQuery)->count();

        // Sorting
        if (in_array($sortOrder, ['asc', 'desc'], true)) {
            $productsQuery->orderBy('selling_price', $sortOrder);
        } else {
            $productsQuery->latest('created_at');
        }

        $products = $productsQuery->paginate(8)->withQueryString();

        // Load filters
        $allcategories = Category::with('parent')->get()->map(function ($category) {
            $category->hierarchy_string = $category->hierarchy_string;
            return $category;
        });

        $colors    = Color::orderByDesc('created_at')->get();
        $sizes     = Size::orderByDesc('created_at')->get();
        $suppliers = Supplier::orderByDesc('created_at')->get();

        return Inertia::render('Products/Index', [
            'products'         => $products,
            'allcategories'    => $allcategories,
            'colors'           => $colors,
            'sizes'            => $sizes,
            'suppliers'        => $suppliers,
            'totalProducts'    => $count,
            'search'           => $search,
            'sort'             => $sortOrder,
            'color'            => $selectedColor,
            'size'             => $selectedSize,
            'stockStatus'      => $stockStatus,
            'selectedCategory' => $selectedCategory,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $categories = Category::all();
    //     $products = Product::all();
    //     $suppliers = Supplier::all();
    //     $colors = Color::all();
    //     $sizes = Size::all();



    //     return Inertia::render('Products/Create', [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'suppliers' => $suppliers,
    //         'colors' => $colors,
    //         'sizes' => $sizes,
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|max:50',
            // 'code' => [
            //     'string',
            //     'max:50',
            //     Rule::unique('products')->whereNull('deleted_at'),
            // ],
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value < $request->input('cost_price')) {
                        $fail('The selling price must be greater than or equal to the cost price.');
                    }
                },
            ],
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'barcode' => 'nullable|string|unique:products',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'expire_date' => 'nullable|date',
            'batch_no' => 'nullable|max:50',
            'purchase_date' => 'nullable|date',
        ]);

        // dd($validated);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $path = $request->file('image')->storeAs('products', $fileName, 'public');
                $validated['image'] = 'storage/' . $path;
            }

            if (empty($validated['barcode'])) {
                $validated['barcode'] = $this->generateUniqueCode(12);
            }
            $validated['total_quantity'] = $validated['stock_quantity'] ?? 0;
            // Create the product
            $product = Product::create($validated);
            // $product->update(['code' => 'PROD-' . $product->id]);

            // Add stock transaction if stock quantity is provided
            $stockQuantity = $validated['stock_quantity'] ?? 0; // Default to 0 if not provided
            if ($stockQuantity > 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'transaction_type' => 'Added',
                    'quantity' => $stockQuantity,
                    'transaction_date' => now(),
                    'supplier_id' => $validated['supplier_id'] ?? null,
                ]);
            }

            // Redirect with success message
            return redirect()->route('products.index')->banner('Product created successfully');
        } catch (\Exception $e) {
            // Log error and redirect back with an error message
            \Log::error('Error creating product: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.');
        }
    }




    public function productVariantStore(Request $request)
    {

        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            // 'code' => 'required|string|max:50|unique:products,code, NULL,id,deleted_at,NULL',
            'barcode' => 'nullable|string|unique:products',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100', // Validation for discount
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|max:2048',
            'expire_date' => 'nullable|date',
        ]);


        try {


            if ($request->hasFile('image')) {
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
                $path = $request->file('image')->storeAs('products', $fileName, 'public');
                $validated['image'] = 'storage/' . $path;
            }


            // Product::create($validated);

            if (empty($validated['barcode'])) {
                $validated['barcode'] = $this->generateUniqueCode(12);
            }

            $product = Product::create($validated);


            // Add stock transaction if stock quantity is provided
            $stockQuantity = $validated['stock_quantity'] ?? 0; // Default to 0 if not provided
            if ($stockQuantity > 0) {
                StockTransaction::create([
                    'product_id' => $product->id,
                    'transaction_type' => 'Added',
                    'quantity' => $stockQuantity,
                    'transaction_date' => now(),
                    'supplier_id' => $validated['supplier_id'] ?? null,
                ]);
            }







            // Redirect with success message
            return redirect()->route('products.index')->banner('Product created successfully');
        } catch (\Exception $e) {
            // Log error and redirect back with an error message
            \Log::error('Error creating product: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the product. Please try again.');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }
        // $categories = Category::all();
        // $sizes = Size::all();
        // $suppliers = Supplier::all();
        // $colors = Color::all();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        $product->load('category', 'color', 'size', 'suppliers');

        return Inertia::render('Products/Show', [

            'categories' => $categories,
            'product' => $product,
            'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $colors = Color::orderBy('created_at', 'desc')->get();
        $sizes = Size::orderBy('created_at', 'desc')->get();
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request, Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'string|max:255',
            // 'code' => 'nullable|string|max:50',
            // 'code' => 'string|max:50|unique:products,code,' . $product->id . ',id,deleted_at,NULL',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|max:2048',
            'expire_date' => 'nullable|date',
            'batch_no' => 'nullable|max:50',
            'purchase_date' => 'nullable|date'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }

            // Save the new image
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'product_' . date("YmdHis") . '.' . $fileExtension;
            $path = $request->file('image')->storeAs('products', $fileName, 'public');
            $validated['image'] = 'storage/' . $path;
        } else {
            $validated['image'] = $product->image;
        }

        // Calculate stock change
        $stockChange = $validated['stock_quantity'] - $product->stock_quantity;

        // Determine transaction type
        $transactionType = $stockChange > 0 ? 'Added' : 'Deducted';
        $validated['total_quantity'] = $validated['stock_quantity'];

        // Update product
        $product->update($validated);



        if ($stockChange !== 0) {
            // Determine transaction type
            $transactionType = $stockChange > 0 ? 'Added' : 'Deducted';

            StockTransaction::create([
                'product_id' => $product->id,
                'transaction_type' => $transactionType,
                'quantity' => abs($stockChange),
                'transaction_date' => now(),
                'supplier_id' => $validated['supplier_id'] ?? null,
            ]);
        }

        return redirect()->route('products.index')->with('banner', 'Product updated successfully');
    }






    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     if (!Gate::allows('hasRole', ['Admin'])) {
    //         abort(403, 'Unauthorized');
    //     }

    //     $imagePath = str_replace('storage/', '', $product->image);

    //     // Check for other products using the same image
    //     $imageUsageCount = Product::where('image', $product->image)
    //         ->where('id', '!=', $product->id)
    //         ->count();

    //     if ($imageUsageCount === 0 && Storage::disk('public')->exists($imagePath)) {
    //         // Delete the image only if no other products are using it
    //         Storage::disk('public')->delete($imagePath);
    //     }

    //     $product->delete();

    //     return redirect()->route('products.index')->banner('Product Deleted successfully.');
    // }



    public function destroy(Product $product)
    {
        if (!Gate::allows('hasRole', ['Admin'])) {
            abort(403, 'Unauthorized');
        }

        // Prepare to delete the image
        $imagePath = str_replace('storage/', '', $product->image);
        $imageUsageCount = Product::where('image', $product->image)
            ->where('id', '!=', $product->id)
            ->count();

        if ($imageUsageCount === 0 && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        try {
            // Log the stock transaction
            StockTransaction::create([
                'product_id' => $product->id,
                'transaction_type' => 'Deleted',
                'quantity' => $product->stock_quantity ?? 0, // Fallback to 0 if undefined
                'transaction_date' => now(),
                'supplier_id' => $product->supplier_id ?? null, // Handle potential null value
            ]);
        } catch (\Exception $e) {
            // Log error and return a failure message
            report($e);
            return redirect()->route('products.index')->withErrors('Failed to log stock transaction. Please try again.');
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->banner('Product Deleted successfully.');
    }
}
