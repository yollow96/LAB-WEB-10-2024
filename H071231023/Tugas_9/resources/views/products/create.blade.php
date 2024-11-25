@extends('layouts.app')

@section('content')
<div
    class="[--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px] m-auto w-4/5 h-auto rounded-2xl bg-white [box-shadow:var(--shadow)] max-w ">
    <div class="px-4 py-5 sm:px-6">
        <h2 class="text-2xl leading-6 text-gray-900 text-center font-bold">Add New Product</h2>
    </div>
    <div class="px-4 py-5 sm:px-6">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="space-y-2 my-3">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <div class="relative mt-1">
                    <select id="category_id" name="category_id" required
                        class="block w-full pl-3 pr-10 py-2 b-1 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md appearance-none">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <div class="flex items-center">
                    <span class="mr-2">$</span>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                @error('price')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-2 my-3">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('stock')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-between">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 text-white font-medium bg-red-600 border border-gray-300 rounded-md hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection