@extends('layouts.indexpage')
@section('title_page')
    {{ __('import.import_vendorproduct_preview') }}
@endsection
@section('index-title')
    {{ __('import.import_vendorproduct_preview') }}
@endsection
@section('table-section')
    <form action="{{ route('import.vendorproduct.save') }}" method="post">
        @csrf
        <div class="mb-4">
            <input type="hidden" name="data" value="{{ json_encode($rows) }}">
            <input type="hidden" name="columns" value="{{ json_encode($columns_db) }}">
            <div class="flex justify-center mt-4 mb-5">
                <div class="flex space-x-">
                    <di>
                        <button class="submit_btn" type="submit">Confirm Import</button>
                        <a href="{{ route('import.vendorproduct') }}">
                            <button class="cancel_btn" onclick="back(event)" type="button">Back</button>
                        </a>
                    </di>
                </div>

            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="table-data">
                <thead>
                    <tr>
                        @foreach ($columns_db as $col)
                            <th>{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </form>
@endsection
@section('js-scripts')
@endsection
