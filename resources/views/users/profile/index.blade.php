@extends('layouts.app')

@section('title', __('users.profile.index.title'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('users.profile.index.title') }}
        </h1>

        {{--<div class="my-2">
            <div class="inline-block bg-gray-300 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('users.profile.add') }}" class="group">
                    <i class="fas fa-plus"></i> <span class="group-hover:underline">{{ __('users.profile.index.add') }}</span>
                </a>
            </div>
        </div>--}}

        <table>
            @foreach($users as $user)
                <?php /** @var Rulla\Authentication\Models\User $user */ ?>
                <tr>
                    <td>
                        <a href="{{ $user->viewUrl }}" class="font-bold inline-block mr-2 hover:underline">
                            {{ $user->identifier }}
                        </a>
                    </td>

                    <td>
                        <a href="{{ $user->viewUrl }}" class="inline-block mr-2 hover:underline">
                            {{ $user->name }}
                        </a>
                    </td>

                    <td class="pr-2 text-gray-700">
                        {{ $user->email }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>

@endsection
