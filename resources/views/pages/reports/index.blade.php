@extends('layouts.indexpage')
@section('title_page')
    Reports index
@endsection
@section('index-title')
    Reports index
@endsection
@section('table-section')
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Report Name 
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($reports as $report) --}}
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        Test View Report
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('report.testReport') }}" class="text-blue-600 hover:underline" target="_blank">View</a>
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
@endsection
