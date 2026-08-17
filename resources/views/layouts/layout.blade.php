<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    @external('gtm')
        {!!   config('google.google_tag.head') !!}
    @endexternal
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    {{-- Флаги сторонних подключений для скриптов из resources/js,
         см. config/external.php --}}
    <script>window.EXTERNAL = @json(external_flags());</script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])
    <link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.url') }}/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.url') }}/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url') }}/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ config('app.url') }}/favicon/site.webmanifest">
    <title>@yield('title', config('seo.seo.title'))</title>
    <meta name="description" content="@yield('description',  config('seo.seo.description'))"/>
    <meta name="keywords" content="@yield('keywords',  config('seo.seo.keywords'))"/>
    {{-- CSS конкретной страницы из админки, см. <x-seo.page-css/> --}}
    @yield('page_css')
</head>
<body>
@external('gtm')
    {!!  config('google.google_tag.body') !!}
@endexternal
    <div class="content_ {{ route_name() }}" data-route-name="{{ route_name() }}">
        @include('html.mobile.top')
        <x-message.message/>
        <x-message.message_error/>
        @include('include.header', ['route' => route_name()]) {{--{{ 'Для стиля главной' }}--}}
        <x-menu.menu/>
        @yield('content')
    </div><!--.content_-->

@include('include.footer')
@include('html.mobile.bottom')

@include('html.temp_forms.order_call')
@include('html.temp_forms.pick_tour')
@include('html.temp_forms.certificate_order')
@include('html.temp_forms.pink_tour_order_mini')
@include('html.temp_forms.pick_tour2_responce')
@include('html.temp_forms.subscription_tour')
@include('html.temp_forms.promo')
@include('html.temp_forms.survey')
@include('html.temp_forms.survey_user')
@include('html.modals.gr')
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    {{-- slick 1.8.1 локально (копия из node_modules/slick-carousel): скрипт
         синхронный, и при недоступном cdn.jsdelivr.net страница вставала
         до TCP-таймаута, а весь JS ниже не выполнялся --}}
    <script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>

    {{-- календарь-диапазон нужен глобально: форма «Подобрать тур» лежит в layout
         и открывается с любой страницы. На страницах поиска эти же файлы
         подключаются своими include'ами — повторный запрос уходит в кеш --}}
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}"/>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/jquery.daterangepicker.min.js') }}"></script>

    @yield('jquery-ui')
    @yield('tourvisor')
    @include('include.connect.connect')
    @include('include.custom_js.custom_js')
</body>
</html>

