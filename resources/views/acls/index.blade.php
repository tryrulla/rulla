@extends('layouts.app')

@section('title', __('acl.all-acls'))

@section('content')
    <div class="card">
        <h1 class="title text-2xl">
            {{ __('acl.all-acls') }}
        </h1>

        <div class="my-2">
            <div class="inline-block bg-gray-300 text-gray-700 p-2 shadow rounded">
                <a href="{{ route('acls.add') }}" class="group">
                    <i class="fas fa-plus"></i> <span class="group-hover:underline">{{ __('general.add') }}</span>
                </a>
            </div>
        </div>

        <table>
            @foreach($acls as $acl)
                <?php /** @var Rulla\Authentication\Models\ACL\AccessControlList $acl */ ?>
                <tr>
                    <td>
                        <a href="{{ $acl->viewUrl }}" class="font-bold inline-block mr-2 hover:underline">
                            {{ $acl->identifier }}
                        </a>
                    </td>

                    <td>
                        <a href="{{ $acl->viewUrl }}" class="inline-block mr-2 hover:underline">
                            {{ $acl->title }}
                        </a>
                    </td>

                    <td>
                        {{ $acl->priority }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $acls->links() }}
    </div>

@endsection
