@if($value === null)
    {{-- nothing --}}
@elseif($value === true)
    True
@elseif($value === false)
    False
@else
    {{ json_encode($value) }}
@endif
