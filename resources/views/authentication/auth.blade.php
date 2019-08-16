@extends('layouts.app')

@inject('authManager', '\Rulla\Authentication\AuthenticationManager')
<?php /** @var $authManager \Rulla\Authentication\AuthenticationManager */ ?>

@section('content')
    @if($authManager->getPasswordProviders()->count() > 0)
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
                        {{ !empty(old('email', '')) ? 'autofocus' : '' }}>
                </label>

                @if($authManager->getPasswordProviders()->count() > 1)
                    <label class="block mt-4">
                        <span class="text-gray-700">{{ __('auth.form.provider') }}</span>
                        <select name="provider" class="form-select mt-1 block w-full">
                            @foreach($authManager->getPasswordProviders() as $provider)
                                <?php /** @var $provider \Rulla\Authentication\Providers\PasswordAuthenticationProvider */ ?>
                                <option value="{{ $provider->getId() }}"
                                    {{ old('provider', isset($selectedProvider) ? $selectedProvider : -1) === $provider->getId() ? 'selected' : '' }}
                                >{{ $provider->getName() }}</option>
                            @endforeach
                        </select>
                    </label>
                @else
                    <input type="hidden" name="provider" value="{{ $authManager->getPasswordProviders()->first()->getId() }}">
                @endif

                <div class="mt-4">
                    <button class="button button-blue">
                        {{ __('auth.form.submit') }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($authManager->getSocialProviders()->count() > 0)
        <div class="card">
            <h2 class="title text-xl">{{ __('auth.social.title') }}</h2>

            @foreach($authManager->getSocialProviders() as $provider)
                <a href="{{ route('login.provider', ['provider' => $provider->getId()]) }}" class="block p-2 bg-white hover:underline mt-4">
                    {{ $provider->getName() }}
                </a>
            @endforeach
        </div>
    @endif
@endsection
