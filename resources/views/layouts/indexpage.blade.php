<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title_page')</title>
    @vite('resources/css/app.css')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/CodeConnextLogo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> --}}
    @yield('js-scripts')
</body>

</html>
