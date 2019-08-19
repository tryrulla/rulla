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
        {{ config('app.name', 'Rulla') }}</title>

    <script>
        window.Rulla = {
            language: '{{ Lang::getLocale() }}'
        };
    </script>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.10.1/css/all.css"
          crossorigin="anonymous">
</head>
<body class="font-sans antialiased text-gray-800 leading-tight bg-gray-300">
<div id="app">
    <div class="container mx-auto py-4">
        <div class="flex bg-white leading-none rounded-lg p-1 shadow justify-between">
            <div class="inline-flex">
                <a href="{{ route('home') }}" class="inline-flex bg-blue-600 text-white rounded h-6 px-3 justify-center items-center">{{ config('app.name', 'Rulla') }}</a>

                @foreach([
                    'types' => route('items.types.index'),
                    'fields' => route('items.fields.index'),
                ] as $key => $link)
                    <a href="{{ $link }}" class="inline-flex justify-center items-center ml-4 hover:underline">
                        {{ __('navbar.' . $key) }}
                    </a>
                @endforeach
            </div>

            <div class="inline-flex mr-2">
                @auth
                    <a href="{{ route('profile') }}" class="inline-flex justify-center items-center ml-4 hover:underline">
                        {{ __('navbar.profile', Auth::user()->toArray()) }}
                    </a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex justify-center items-center ml-4 hover:underline">
                        {{ __('navbar.logout') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center ml-4 hover:underline">
                        {{ __('navbar.login') }}
                    </a>
                @endif
            </div>
        </div>

        @if($errors->any())
            <div class="card card-no-bg bg-red-100 text-red-900">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(Session::has('notice'))
            <div class="card card-no-bg bg-blue-100 text-blue-900">
                <div>
                    {{ Session::get('notice') }}
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
