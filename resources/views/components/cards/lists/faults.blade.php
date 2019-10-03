<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($faults as $fault)
                <?php /** @var Rulla\Items\Instances\ItemFault $fault */ ?>
                <tr>
                    <td class="pr-4 text-gray-700">
                        <a href="{{ $fault->viewUrl }}" class="hover:underline">
                            {{ $fault->identifier }}
                        </a>
                    </td>

                    <td class="pr-2">
                        {{ $fault->title }}
                    </td>

                    <td class="pr-2">
                        {{ \Rulla\Utils\Date::format($fault->created_at) }}
                    </td>

                    <td class="pr-2">
                        {{ $fault->closed ? __('items.faults.fields.closed') : __('items.faults.fields.open') }}
                    </td>

                    @if(isset($showAssignee) && $showAssignee)
                        <td class="pr-2">
                            @if($fault->assignee)
                                <a href="{{ $fault->assignee->viewUrl }}">
                                    <span class="hover:underline text-gray-900 hover:text-black">
                                        {{ $fault->assignee->name }}

                                        <span class="text-gray-700">
                                            ({{ $fault->assignee->email }})
                                        </span>
                                    </span>
                                </a>
                            @else
                                <span class="text-gray-700">
                                    &ndash;
                                </span>
                            @endif
                        </td>
                    @endif

                    @if(isset($showItem) && $showItem)
                        <td class="pr-2">
                            <a href="{{ route('items.instances.view', $fault->item->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $fault->item->identifier }}
                                </span>

                                {{ $fault->item->tag }}
                            </a>
                        </td>

                        <td class="pr-2">
                            <a href="{{ route('items.types.view', $fault->item->type->id) }}" class="hover:underline">
                                <span class="text-gray-700">
                                    {{ $fault->item->type->identifier }}
                                </span>

                                {{ $fault->item->type->name }}
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</div>
