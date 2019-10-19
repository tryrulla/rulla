@extends('layouts.app')

@section('title', __('users.profile.edit.title', $user->toArray()))

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ __('users.profile.edit.title', $user->toArray()) }}
        </h1>

        <form action="{{ route('user.profile.update', $user) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('users.profile.edit.form.name') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name', $user->name) }}">
                </label>
            </div>

            <div class="card">
                <div>
                    <span class="text-gray-700">Label</span>
                    <multi-input
                        :type="{{ json_encode(\Rulla\Authentication\Models\Groups\Group::class) }}"
                        name="groups"
                    ></multi-input>
                </div>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('users.profile.edit.submit') }}
                </button>
            </div>
        </form>
    </div>

@endsection
