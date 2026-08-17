@props([
    'width' => 234,
    'height' => 42,
    'alt' => 'logo',

])

<div  {{ $attributes->class([
    'logo'
]) }}>
    @if( active_link('home') )

        <img alt="{{ $alt }}" width="{{$width}}" height="{{$height}}" src="{{ asset('images/inline/components-logo-logo-footer-1.svg') }}">
    @else
        <a href="/" style="text-decoration: none">
            <img alt="{{ $alt }}" width="{{$width}}" height="{{$height}}" src="{{ asset('images/inline/components-logo-logo-footer-1.svg') }}">
        </a>
    @endif

</div>
