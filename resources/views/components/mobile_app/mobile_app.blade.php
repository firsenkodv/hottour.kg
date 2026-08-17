@props([
    'width' => 172,
    'height' => 48,

])
<div class="android_ios">
    <a data-fancybox="" class="Qr__ios" href="#gr-app">
        <img alt="ios" width="{{ $width }}" height="{{ $height }}" src="{{ asset('images/inline/components-mobile-app-mobile-app-1.svg') }}"></a>

    <a data-fancybox=""  class="Qr__and" href="#gr-app">
        <img alt="android" width="{{ $width }}" height="{{ $height }}"  src="{{ asset('images/inline/components-mobile-app-mobile-app-2.svg') }}">
       </a>
</div>
