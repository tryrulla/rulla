@extends('layouts.app')

@section('title', $group->name)

@section('content')
    <div class="mt-4">
        <h3 class="font-bold">
            {{ $group->identifier }}
        </h3>

        <h1 class="title text-2xl">
            {{ $group->name }}
        </h1>

        <div class="mt-2">
            <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('user.groups.edit', $group) }}" class="group">
                    <i class="fas fa-pen"></i> <span
                        class="group-hover:underline">{{ __('users.groups.edit') }}</span>
                </a>
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('general.cards.details') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('users.groups.fields.id') }}
                        </th>

                        <td>
                            {{ $group->identifier }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('users.profile.view.details.name') }}
                        </th>

                        <td>
                            {{ $group->name }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
