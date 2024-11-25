@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md [--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px] m-auto w-4/5 h-auto rounded-2xl bg-white [box-shadow:var(--shadow)] max-w ">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-2xl leading-6 font-bold text-gray-900">Edit Product</h2>
    </div>
    <div class="px-4 py-5 sm:px-6">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-2 my-3">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category_id" name="category_id" required class="block w-full pl-3 pr-10 py-2 b-1 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md appearance-none">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <div class="flex items-center">
                    <span class="mr-2">$</span>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                @error('price')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('stock')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-between">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 text-white font-medium bg-red-600 border border-gray-300 rounded-md hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection