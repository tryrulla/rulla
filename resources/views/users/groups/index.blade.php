@extends('layouts.app')

@section('title', __('users.groups.all-groups'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('users.groups.all-groups') }}
        </h1>

        {{--<div class="my-2">
            <div class="inline-block bg-gray-300 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('users.groups.add') }}" class="group">
                    <i class="fas fa-plus"></i> <span class="group-hover:underline">{{ __('users.group.index.add') }}</span>
                </a>
            </div>
        </div>--}}

        <table>
            @foreach($groups as $group)
                <?php /** @var Rulla\Authentication\Models\Groups\Group $group */ ?>
                <tr>
                    <td>
                        <a href="{{ $group->viewUrl }}" class="font-bold inline-block mr-2 hover:underline">
                            {{ $group->identifier }}
                        </a>
                    </td>

                    <td>
                        <a href="{{ $group->viewUrl }}" class="inline-block mr-2 hover:underline">
                            {{ $group->name }}
                        </a>
                    </td>

                    <td class="pr-2 text-gray-700">
                        {{ $group->email }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $groups->links() }}
    </div>

@endsection
