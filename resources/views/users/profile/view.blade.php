@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ $user->name }}
        </h1>

        <div class="mt-2">
            <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('user.profile.edit', $user) }}" class="group">
                    <i class="fas fa-pen"></i> <span
                        class="group-hover:underline">{{ __('users.profile.view.edit') }}</span>
                </a>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('users.profile.view.details.title') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('users.profile.view.details.id') }}
                        </th>

                        <td>
                            {{ $user->id }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('users.profile.view.details.name') }}
                        </th>

                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('users.profile.view.details.email') }}
                        </th>

                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
