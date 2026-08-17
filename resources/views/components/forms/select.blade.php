@props([
  'placeholder' => '',
  'isError' => false,
  'name' => '',
  'value' => '',
  'text' => ''
])

<div class="select">
    <input class="select__input" value="{{ $value }}" type="hidden" name="{{ $name }}">
    <div  {{ $attributes->class([
            '_is-error' => $isError,
            'select__head'
            ]) }}
    >{{ $text }}</div>
    {{ $slot }}
</div>
