@extends('layouts.app')

@section('title', $acl->identifier)

@section('content')
    <div class="mt-4">
        <h1 class="title text-2xl">
            {{ $acl->identifier }}
        </h1>

        @if($acl->system)
            <div class="bg-white flex items-center leading-none text-blue-700 rounded-full p-2 shadow-lg mb-4">
                <span class="inline-flex bg-blue-600 text-white rounded-full h-6 px-3 justify-center items-center">
                    {{ __('acl.view.system.title') }}
                </span>
                <span class="px-2">
                    {{ __('acl.view.system.text') }}
                </span>
            </div>
        @else
            <div class="mt-2">
                <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                    <a href="{{ route('items.fields.edit', $acl->id) }}" class="group">
                        <i class="fas fa-pen"></i> <span class="group-hover:underline">{{ __('general.edit') }}</span>
                    </a>
                </div>
            </div>
        @endif

        <div class="card">
            <h3 class="font-bold">
                {{ __('general.cards.details') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('acl.fields.title') }}
                        </th>

                        <td>
                            {{ $acl->title }}
                        </td>
                    </tr>


                    <tr>
                        <th class="pr-4">
                            {{ __('acl.fields.priority') }}
                        </th>

                        <td>
                            {{ $acl->priority }}
                        </td>
                    </tr>

                    <tr>
                        <th class="pr-4">
                            {{ __('acl.fields.data') }}
                        </th>

                        <td>
                            {{ json_encode($acl->data) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
