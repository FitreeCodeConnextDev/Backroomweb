<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title_page')</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="shortcut icon" href="{{ asset('logo/CodeConnextLogo.png') }}">

</head>

<body>
    @include('layouts.sidbar_test')
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-12 border-2 border-gray-200 border-dashed rounded-lg">
            <div class="pb-4 mb-4 rounded-t ">
                <div class=" absolute end-1 px-6">
                    @yield('toast')
                </div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol>
                        <li class="inline-flex items-center">
                            @yield('breadcrumb-index')
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                @yield('breadcrumb-create-page')
                            </div>
                        </li>

                    </ol>
                </nav>
            </div>
            <div class="create_page_title">
                <h3 class="text_h3">@yield('page_title')</h3>
            </div>
            <div class="grid_create">
                @yield('form-section')
            </div>

        </div>
    </div>
     @vite('resources/js/app.js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('js-scripts')
</body>

</html>
