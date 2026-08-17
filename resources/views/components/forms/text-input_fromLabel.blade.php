@props([
    'type' => '',
    'value'=> '',
    'isError' => false,
    'placeholder' => '',
    'id' => ''
])
<input
    type="{{ $type  }}"
    id="{{ $id }}"
    value="{{ $value  }}"
    {{ $attributes->class([
    '_is-error' => $isError,
    'inputClass'
]) }}
><label class="labelInput" for="{{ $id }}">{{ $placeholder }}</label>



