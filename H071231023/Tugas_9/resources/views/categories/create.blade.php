@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-8 bg-white shadow-md rounded-lg [--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px]  rounded-2xl bg-white [box-shadow:var(--shadow)]">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-800">Add New Category</h2>
    </div>
    <div class="mt-6">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 text-red-900 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 text-red-900 @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-between">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 text-white font-medium bg-red-600 border border-gray-300 rounded-md hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection