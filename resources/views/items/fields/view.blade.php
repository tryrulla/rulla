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
        @else
            <div class="mt-2">
                <div class="inline-block bg-gray-100 text-gray-700 p-2 shadow rounded">
                    <a href="{{ route('items.fields.edit', $field->id) }}" class="group">
                        <i class="fas fa-pen"></i> <span class="group-hover:underline">{{ __('items.fields.view.edit') }}</span>
                    </a>
                </div>
            </div>
        @endif

        <div class="card">
            <h3 class="font-bold">
                {{ __('items.fields.view.details.title') }}
            </h3>

            <div class="px-2">
                <table>
                    <tr>
                        <th class="pr-4">
                            {{ __('items.fields.view.details.type') }}
                        </th>

                        <td>
                            {{ __('items.fields.types.' . $field->type) }}
                        </td>
                    </tr>

                    @if($field->type->isNumber())
                        <tr>
                            <th class="pr-4">
                                {{ __('items.fields.extra_options.unit') }}
                            </th>

                            <td>
                                {{ $field->getOptions()->unit }}
                            </td>
                        </tr>

                        <tr>
                            <th class="pr-4">
                                {{ __('items.fields.extra_options.decimals') }}
                            </th>

                            <td>
                                {{ $field->getOptions()->decimals || '0' }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

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

                            <td class="pr-4">
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
            </div>
        </div>

        <div class="card">
            <h3 class="font-bold">
                {{ __('items.fields.view.applies.title') }}
            </h3>

            <div class="px-2">
                <table>
                    @foreach($field->appliesTo as $row)
                        <?php /** @var \Rulla\Items\Fields\FieldAppliesTo $row */ ?>
                        <tr>
                            <td class="pr-4">
                                <a href="{{ $row->type->view_url }}" class="text-gray-700 hover:underline">
                                    {{ $row->type->identifier }}</a>
                            </td>

                            <td class="pr-4">
                                <a href="{{ $row->type->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $row->type->name }}</span>
                                </a>
                            </td>

                            <td class="pr-4">
                                {{ $row->mode->map(function ($mode) { return __('items.fields.modes.' . $mode); })->join(', ') }}
                            </td>

                            <td>
                                <form action="{{ route('items.field-apply.destroy', $row) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-900 hover:underline">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="mt-2 text-gray-600 text-xs">
                    <a href="{{ route('items.field-apply.add', ['field_id' => $field->id]) }}" class="hover:underline">
                        <i class="fas fa-pen"></i> {{ __('items.fields.view.applies.add') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
