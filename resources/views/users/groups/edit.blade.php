@extends('layouts.app')

@section('title', __('users.groups.edit'))

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ __('users.groups.edit') }}
        </h1>

        <form action="{{ route('user.groups.update', $group->id) }}" method="POST">
            @csrf

            <div class="card">
                <label class="block">
                    <span class="text-gray-700">{{ __('users.groups.fields.name') }}</span>
                    <input class="form-input mt-1 block w-full" type="text" name="name" value="{{ old('name', $group->name) }}">
                </label>
            </div>

            <div class="card">
                <button class="button button-blue">
                    {{ __('general.submit') }}
                </button>
            </div>
        </form>
    </div>

@endsection
