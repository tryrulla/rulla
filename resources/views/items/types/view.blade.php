@extends('layouts.app')

@section('title', $type->identifier)

@section('content')
    @if($errors->any())
        <div class="card">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <h3 class="font-bold">
            {{ $type->identifier }}
        </h3>

        <h1 class="title text-2xl">
            {{ $type->name }}
        </h1>

        @if($type->system)
            <div class="bg-gray-300 flex items-center leading-none text-blue-700 rounded-full p-2 shadow-lg mb-4">
                <span class="inline-flex bg-blue-600 text-white rounded-full h-6 px-3 justify-center items-center">
                    {{ __('items.types.view.system.title') }}
                </span>
                <span class="px-2">
                    {{ __('items.types.view.system.text') }}
                </span>
            </div>
        @endif

        <table>
            @if($type->parent)
                <tr>
                    <th>
                        Parent
                    </th>

                    <td>
                        <a href="{{ route('items.types.view', $type->parent) }}" class="hover:underline hover:text-black">
                            {{ $type->parent->name }}</a>

                        @if($type->parent->system)
                            <span class="pl-1 text-gray-700">
                                    {{ __('items.types.index.system') }}
                            </span>
                        @endif
                    </td>
                </tr>
            @endif
        </table>

        @if($type->parent)

        @endif

        {{ json_encode($type) }}
    </div>

@endsection
