@extends('layouts.app')

@section('content')
    @if($passwordProviders->count() > 0)
        <div class="card">
            <h2 class="title text-xl">{{ __('auth.form.title') }}</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <label class="block mt-4">
                    <span class="text-gray-700">{{ __('auth.form.email') }}</span>
                    <input class="form-input mt-1 block w-full" type="email" name="email"
                           placeholder="{{ __('auth.form.example_email') }}" value="{{ old('email') }}"
                            {{ empty(old('email', '')) ? 'autofocus' : '' }}>
                </label>

                <label class="block mt-4">
                    <span class="text-gray-700">{{ __('auth.form.password') }}</span>
                    <input class="form-input mt-1 block w-full" type="password" name="password" placeholder="●●●●●●●●●●●●●●●●"
                        {{ empty(old('email', '')) ? '' : 'autofocus' }}>
                </label>

                @if($passwordProviders->count() > 1)
                    <label class="block mt-4">
                        <span class="text-gray-700">{{ __('auth.form.provider') }}</span>
                        <select name="provider" class="form-select mt-1 block w-full">
                            @foreach($passwordProviders as $provider)
                                <?php /** @var $provider \Rulla\Authentication\Providers\PasswordAuthenticationProvider */ ?>
                                <option value="{{ $provider->getId() }}"
                                    {{ old('provider', isset($selectedProvider) ? $selectedProvider : -1) === $provider->getId() ? 'selected' : '' }}
                                >{{ $provider->getName() }}</option>
                            @endforeach
                        </select>
                    </label>
                @else
                    <input type="hidden" name="provider" value="{{ $passwordProviders->first()->getId() }}">
                @endif

                <label class="block mt-4">
                    <input class="form-checkbox" type="checkbox" name="remember">
                    <span class="text-gray-700">{{ __('auth.form.remember') }}</span>
                </label>

                <div class="mt-4">
                    <button class="button button-blue">
                        {{ __('auth.form.submit') }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($socialProviders->count() > 0)
        <div class="card">
            <h2 class="title text-xl">{{ __('auth.social.title') }}</h2>

            @foreach($socialProviders as $provider)
                <a href="{{ route('login.provider', ['provider' => $provider->getId()]) }}" class="block p-2 bg-white hover:underline mt-4">
                    {{ $provider->getName() }}
                </a>
            @endforeach
        </div>
    @endif
@endsection
