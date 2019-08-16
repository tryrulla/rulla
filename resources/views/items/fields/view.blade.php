@extends('layouts.app')

@section('title', $field->identifier)

@section('content')
    <div class="mt-4">
        <h3 class="font-bold">
            {{ $field->identifier }}
        </h3>

        <h1 class="title text-2xl">
            {{ $field->name }}
        </h1>

        @if($field->system)
            <div class="bg-white flex items-center leading-none text-blue-700 rounded-full p-2 shadow-lg mb-4">
                <span class="inline-flex bg-blue-600 text-white rounded-full h-6 px-3 justify-center items-center">
                    {{ __('items.fields.view.system.title') }}
                </span>
                <span class="px-2">
                    {{ __('items.fields.view.system.text') }}
                </span>
            </div>
        @endif

        <div class="card">
            <h3 class="font-bold">
                {{ __('items.fields.view.values.title') }}
            </h3>

            <div class="px-2">
                <table>
                    @foreach($field->values as $value)
                        <?php /** @var \Rulla\Items\Fields\FieldValue $value */ ?>
                        <tr>
                            <td class="pr-4">
                                <a href="{{ $value->valueHolder->viewUrl }}" class="text-gray-700 hover:underline">
                                    {{ $value->valueHolder->identifier }}</a>
                            </td>

                            <td>
                                <a href="{{ $value->valueHolder->viewUrl }}">
                                        <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $value->valueHolder->name }}</span>
                                </a>
                            </td>

                            <td>
                                {{ $value->getFormattedValue() }}
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="mt-2 text-gray-600 text-xs">
                    <i class="fas fa-pen"></i> {{ __('items.fields.view.values.add') }}
                </div>
            </div>
        </div>

        {{ json_encode($field) }}
    </div>

@endsection
