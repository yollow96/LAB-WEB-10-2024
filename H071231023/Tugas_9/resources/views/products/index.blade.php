@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold text-white">Products</h2>
    <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Add New Product</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md [--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px]  rounded-2xl bg-white [box-shadow:var(--shadow)]">
    <div class="px-4 py-5 sm:px-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${{ number_format($product->price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->stock }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white bg-red-600 hover:bg-red-700">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection