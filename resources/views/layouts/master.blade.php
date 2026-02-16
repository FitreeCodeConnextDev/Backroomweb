<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="{{ asset('logo/CodeConnextLogo.png') }}">

    <title>@yield('title')</title>
</head>

<body>
    @include('layouts.sidbar_test')
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-12 border-2 border-gray-200 border-dashed rounded-lg">
            @yield('content')
        </div>
    </div>
    <section id="main" class="row">
        <div class="flex flex-col mx-auto">
            <div class="p-4 mt-12 sm:ml-64">
                <div class="w-full bg-white p-4 md:p-6">
                    @yield('body')
                </div>
            </div>
        </div>
    </section>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>

</html>
