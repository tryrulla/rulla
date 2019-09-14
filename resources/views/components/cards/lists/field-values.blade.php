<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($fields as $field)
                <?php /** @var \Rulla\Items\Fields\FieldValue $field */ ?>
                <tr>
                    <td class="pr-4">
                        <a href="{{ $field->field->viewUrl }}" class="text-gray-700 hover:underline">
                            {{ $field->field->identifier }}</a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $field->field->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $field->field->name }}</span>
                        </a>
                    </td>

                    <td>
                        {{ $field->getFormattedValue() }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
