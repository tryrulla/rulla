<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <title>
        @hasSection('title')
        @yield('title') &ndash;
        @endif
        {{ config('app.name', 'Rulla') }}</title>

    @javascript('Rulla', [
        'language' => Lang::getLocale(),
        'baseUrl' => url(route('home')),
        'currentUser' => Auth::check() ? Auth::user()->identifier : null,
        'identifiers' => [
            'letterToType' => [
                'I' => \Rulla\Items\Instances\Item::class,
                'T' => \Rulla\Items\Types\ItemType::class,
                'F' => \Rulla\Items\Fields\Field::class,
                'U' => \Rulla\Authentication\Models\User::class,
                'G' => \Rulla\Authentication\Models\Groups\Group::class,
            ],
            'typeToLetter' => [
                \Rulla\Items\Instances\Item::class => 'I',
                \Rulla\Items\Types\ItemType::class => 'T',
                \Rulla\Items\Fields\Field::class => 'F',
                \Rulla\Authentication\Models\User::class => 'U',
                \Rulla\Authentication\Models\Groups\Group::class => 'G',
            ],
        ]
    ])

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.10.2/css/all.css"
          crossorigin="anonymous">
</head>
<body class="font-sans antialiased text-gray-800 leading-tight bg-gray-300 border-t-8 border-blue-500">
<div id="app">
    <div class="container max-md:px-2 md:mx-auto py-4">
        <div class="md:flex bg-white leading-none rounded-lg p-1 shadow justify-between">
            <div class="md:inline-flex max-md:inline-block">
                <a href="{{ route('home') }}"
                   class="inline-flex bg-blue-600 text-white rounded h-6 px-3 justify-center items-center">{{ config('app.name', 'Rulla') }}</a>

                @foreach([
                    'items' => route('items.instances.index'),
                    'types' => route('items.types.index'),
                    'fields' => route('items.fields.index'),
                    'users' => route('user.profile.index'),
                    'groups' => route('user.groups.index'),
                    'acls' => route('acls.index'),
                ] as $key => $link)
                    <a href="{{ $link }}" class="navbar-item hover:underline">
                        {{ __('navbar.' . $key) }}
                    </a>
                @endforeach
            </div>

            <div class="md:inline-flex max-md:inline-block mr-2">
                @auth
                    <a href="{{ route('user.profile.self') }}"
                       class="navbar-item hover:underline">
                        {{ __('navbar.profile', Auth::user()->toArray()) }}
                    </a>

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="navbar-item hover:underline">
                        {{ __('navbar.logout') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="navbar-item hover:underline">
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

        <div class="text-center text-xs text-gray-600 mt-1">Powered by
            <a href="https://github.com/tryrulla" class="hover:underline">Rulla</a>{!! \Rulla\Utils\Version::getVersion() !!}.
            The current time is {{ \Rulla\Utils\Date::format(new DateTime()) }}.
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="{{ url(mix('js/app.js')) }}"></script>
</body>
</html>
