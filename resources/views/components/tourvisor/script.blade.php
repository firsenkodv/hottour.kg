{{-- Блок скрипта у материала.

     Если задан номер модуля Tourvisor — разметку рисует этот компонент, и
     редактору негде ошибиться: в базе лежит только число. Если номера нет —
     выводим старое поле `script` как есть, чтобы уже заполненные записи и
     нетиповые вставки (виджет круизов gocruise.ru на pages id=1) работали
     по-прежнему.

     Разметка обёрнута в @external('tourvisor_js'): при EXTERNAL_SERVICES=false
     запрос на tourvisor.ru не уходит вовсе. Раньше поле `script` этот рубильник
     обходило, и локально страница висела до таймаута к недоступному домену. --}}
@props([
    'model' => null,
    'module' => null,
    'script' => null,
])

@php
    $module ??= $model?->tourvisor_module_id;
    $script ??= $model?->script;
@endphp

@if (filled($module))
    @external('tourvisor_js')
        <div class="tv-hot-tours tv-moduleid-{{ $module }}"></div>
        <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>
    @else
        <x-external.disabled service="Горящие туры Tourvisor"/>
    @endexternal
@endif

{{-- Поля независимы: заполнены оба — выводится и виджет, и своя вставка.
     Через @elseif номер модуля молча съедал бы содержимое поля «Скрипт»,
     и редактор не понимал бы, почему введённое не появляется на странице. --}}
@if (filled($script))
    {!! $script !!}
@endif
