{{-- CSS страницы из админки (поле custom_css).
     Правила уходят в <style> в <head> через @yield('page_css') в
     layouts/layout.blade.php — так они применяются до первой отрисовки
     и не дают мигания стилей. Вызывается рядом с <x-seo.meta/>, то есть
     до @section('content'), как и остальные head-секции. --}}
@props([
    'css' => null,
])

@if(filled($css))
    @section('page_css')
        <style>{!! $css !!}</style>
    @endsection
@endif
