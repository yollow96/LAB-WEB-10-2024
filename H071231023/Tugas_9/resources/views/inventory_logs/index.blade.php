@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4 ">
    <h2 class="text-2xl font-bold text-white">Inventory Logs</h2>
    <a href="{{ route('inventory-logs.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Add New Log</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md [--shadow:rgba(60,64,67,0.3)_0_1px_2px_0,rgba(60,64,67,0.15)_0_2px_6px_2px]  rounded-2xl bg-white [box-shadow:var(--shadow)]">
    <div class="px-4 py-5 sm:px-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantity
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($logs as $log)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $log->date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $log->product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $log->type === 'restock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($log->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        {{ $log->quantity }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection