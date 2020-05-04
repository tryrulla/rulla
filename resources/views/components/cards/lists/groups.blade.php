<div class="card">
    <h3 class="font-bold">
        {{ $title }}
    </h3>

    <div class="px-2">
        <table>
            @foreach($groups as $group)
                <?php /** @var \Rulla\Authentication\Models\Groups\Group $group */ ?>
                <tr>
                    <td class="pr-4">
                        <a href="{{ $group->viewUrl }}" class="text-gray-700 hover:underline">
                            {{ $group->identifier }}</a>
                    </td>

                    <td class="pr-2">
                        <a href="{{ $group->viewUrl }}">
                            <span class="hover:underline text-gray-900 hover:text-black">
                                {{ $group->name }}</span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
