@props([
    'value'=> '',
    'isError' => false,
    'placeholder' => '',
     'id'   =>  '',


])

<textarea
      id="{{ $id }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->class([
    '_is-error' => $isError,
    'inputClassCabinet'
]) }}

>{{ $value  }}</textarea>

