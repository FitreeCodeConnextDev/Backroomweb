<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title_page')</title>
    @vite('resources/css/app.css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/CodeConnextLogo.png') }}">

</head>
@include('layouts.sidbar_test')

<body>

    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-16 border-2 border-gray-200 border-dashed rounded-lg">
            <div class="card-body">
                <div class="index_header">
                    <div class="flex-between ">
                        {{-- title --}}
                        <caption class="caption-title">
                            <h1 class="text-title">
                                {{-- title --}}
                                @yield('index-title')
                            </h1>
                        </caption>
                        {{-- title --}}
                        {{-- add button --}}
                        <div>
                            {{-- ปุ่ม create --}}
                            @yield('add-button')
                        </div>
                        {{-- add button --}}
                    </div>
                </div>
                @yield('table-section')
            </div>
        </div>
    </div>
    <script src="https://jquery.com"></script>
    @vite('resources/js/app.js')
    @yield('js-scripts')
    @stack('scripts')
</body>

</html>
