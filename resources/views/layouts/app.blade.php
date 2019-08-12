<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <title>
        @hasSection('title')
            @yield('title') &ndash;
        @endif
        {{ config('app.name', 'Laravel') }}</title>
</head>
<body class="font-sans antialiased text-gray-800 leading-tight bg-gray-300">
<div id="app">
    <div class="container mx-auto py-4">
        <div class="">
            Rulla Menu Bar
        </div>

        @yield('content')
    </div>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
