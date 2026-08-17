@props([
    'type' => 'text',
    'value'=> '',
    'isError' => false,
    'placeholder' => '',
     'id'   =>  '',
     'min' =>  '',
     'max' =>  '',
     'step' =>  '',

])

<input
    type="{{ $type  }}"
    id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value  }}"
    @if($min or $min == 0)
        min="{{ $min }}"
    @endif
    @if($max)
        max="{{ $max }}"
    @endif
    @if($step)
        step="{{ $step }}"
    @endif

    {{ $attributes->class([
    '_is-error' => $isError,
    'inputClassCabinet'
]) }}

>

