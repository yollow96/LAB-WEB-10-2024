<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryLogController extends Controller
{
    public function index()
    {
        $logs = InventoryLog::with('product')->orderBy('date', 'desc')->get();
        return view('inventory_logs.index', compact('logs'));
    }

    public function create()
    {
        $products = Product::all();
        return view('inventory_logs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:restock,sold',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date'
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            
            if ($request->type === 'sold' && $product->stock < $request->quantity) {
                throw new \Exception('Insufficient stock available.');
            }
            
            // Update product stock
            $product->stock += ($request->type === 'restock' ? $request->quantity : -$request->quantity);
            $product->save();
            
            // Create inventory log
            InventoryLog::create($request->all());
        });

        return redirect()->route('inventory-logs.index')
            ->with('success', 'Inventory log created successfully.');
    }
}