@extends('layouts.layout')
@section('content')

    <main class="page_search__wrapper">
        @include('include.search.select.select_search_type')

        <div class="block">
        @if(config('tourvisor.module_findtour'))
        <div class="pad_t40  tv-search-form tv-moduleid-{{ config('tourvisor.module_findtour') }}"></div>
        @external('tourvisor_js')
            {{-- скрипт синхронный: при недоступном tourvisor.ru (VPN) вешает страницу --}}
            <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>
        @else
            <x-external.disabled service="Модуль поиска Tourvisor"/>
        @endexternal
        @endif
        </div>

        <section class="z-index-23 pad_t16 pad_b16 ">
            @include('include.module.hottours')
        </section>

        <div class="block">
            <div class="hbox temp_img">
                <div class="hbox__top pad_b1">

                    <h1>Поиск тура online</h1>
                </div>

            </div>
        <div class="desc_static desc pad_b60_important">
            <p style="text-align: justify;"><strong>Поиск и Бронирование тура Online.</strong>&nbsp;Все направления и страны. Подобрать недорогой тур для отдыха. Все туроператоры и безопасные авиалинии.</p>
            <p style="text-align: justify;">Подбор туров в Турцию, Эмираты, Тайланд, Египет, Малайзию, Европу и т.д. online с вылетом из Москвы, Санкт-Петербурга, России, удобная форма подбора тура от всех ведущих туроператоров России.</p>
            <h3 style="text-align: justify;"><strong>Внимание !!!</strong></h3>
            <ul style="text-align: justify;">
                <li>Поиск выводит только&nbsp;<strong>недорогие туры</strong>&nbsp;если Вам нужен какой-то конкретный отель нужно указать его название отдельно</li>
                <li>Найти самые лучшие отели в своей категории (5/4/3 звезды) можно указав на&nbsp;<strong>Минимальный рейтинг отеля</strong></li>
                <li>Цена тура может&nbsp;<strong>незначительно измениться</strong></li>
            </ul>
            <p style="text-align: justify;"><strong><a href="/kontakty">HOT TOUR</a></strong>&nbsp;предлагает воспользоваться нашей формой подбора тура, для предварительной информации о Ваших предпочитаемых направлениях. Вы можете найти&nbsp;<strong>самый дешевый тур</strong>&nbsp;в пяти звёздочный отель на нашем сайте потратив всего пять минут так же<strong>&nbsp;туры по самым низким ценам</strong>&nbsp;в прямом доступе.</p>
            <h3 style="text-align: justify;"><strong>Инструкция:</strong></h3>
            <p style="text-align: justify;">1. При выборе тура используются различные базы данных, но ни одна база данных не может точно и корректно отразить всё многообразие туристических маршрутов.</p>
            <p style="text-align: justify;">Поэтому если Вы не смогли найти в форме On line бронирования интересующий Вас тур или направление, обратитесь непосредственно к менеджера HOT TOUR.</p>
            <p style="text-align: justify;">2. Если после указания всех данных в поле "ТУР" не появился город или курорт это означает что в данное время по данному направлению нет информации либо маршрута.</p>
            <p style="text-align: justify;">3. После подбора тура необходимо отправить отобранный Вами тур через форму&nbsp;заказ тура&nbsp;либо сообщить&nbsp;<a href="/kontakty" title="Контакты">по телефонам</a>.</p>        </div>
        </div>
    </main>
    @include('html.temp_forms.reserve_hotel')

@endsection



