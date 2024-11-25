@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md [--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px]  rounded-2xl bg-white [box-shadow:var(--shadow)]">
    <div class="px-4 py-5 sm:px-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Add Inventory Log</h2>
        </div>
        <form action="{{ route('inventory-logs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                <select class="block w-full pl-3 pr-10 py-2 b-1 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md appearance-none" id="product_id" name="product_id" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Current Stock: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select class="block w-full pl-3 pr-10 py-2 b-1 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md appearance-none" id="type" name="type" required>
                    <option value="restock" {{ old(key: 'type') == 'restock' ? 'selected' : '' }}>Restock</option>
                    <option value="sold" {{ old('type') == 'sold' ? 'selected' : '' }}>Sold</option>
                </select>
                @error('type')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                @error('quantity')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" class="block w-full px-3 py-2 text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-between">
                <a href="{{ route('inventory-logs.index') }}" class="inline-flex items-center px-4 py-2 text-white font-medium bg-red-600 border border-gray-300 rounded-md hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-gray-300">Cancel</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">Create Log</button>
            </div>
        </form>
    </div>
</div>
@endsection