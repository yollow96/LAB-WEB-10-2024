<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create($request->all());
            
            // Create initial inventory log
            InventoryLog::create([
                'product_id' => $product->id,
                'type' => 'restock',
                'quantity' => $request->stock,
                'date' => now()
            ]);
        });

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($request, $product) {
            $oldStock = $product->stock;
            $newStock = $request->stock;
            
            if ($oldStock != $newStock) {
                $difference = $newStock - $oldStock;
                InventoryLog::create([
                    'product_id' => $product->id,
                    'type' => $difference > 0 ? 'restock' : 'sold',
                    'quantity' => abs($difference),
                    'date' => now()
                ]);
            }
            
            $product->update($request->all());
        });

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
