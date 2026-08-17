{{-- Календарь (jquery-date-range-picker) — единая точка разметки и настроек.

     Инициализация одна на все календари — resources/js/datepicker.js,
     внешний вид — resources/css/forms/datepicker.scss (надстройка над
     public/css/daterangepicker.css). Плагин и moment.js подключены в лейаутах.

     Режимы:
       mode="range"              — интервал дат: видимое поле + скрытое с name
                                   (формы поиска туров);
       mode="range" + floating   — одно поле в стиле модальных форм,
                                   с плавающей подписью и крестиком очистки;
       mode="birthdate"          — одна дата с выбором месяца/года
                                   (кабинет: дата рождения, сертификаты, договор).

     direction: auto — календарь открывается вниз, но переворачивается вверх,
                когда внизу не хватает места; up / down — принудительно.
     container — селектор родителя, внутри которого рисуется календарь
                (нужно в модалках, иначе он остаётся под оверлеем fancybox). --}}
@props([
    'name' => 'daterange',
    'mode' => 'range',
    'value' => '',
    'display' => '',
    'placeholder' => '',
    'floating' => false,
    'direction' => 'auto',
    'container' => null,
    'yearsFrom' => 1952,
    'resultText' => '',
    'inputId' => null,
    'resultId' => null,
    'maxSpan' => null,
])

@if($mode === 'birthdate')

    <div {{ $attributes->merge(['class' => 'birthdate_pic']) }}
         data-datepicker="birthdate"
         data-direction="{{ $direction }}"
         data-years-from="{{ $yearsFrom }}">
        <input type="text" name="{{ $name }}" @if($inputId) id="{{ $inputId }}" @endif
               class="datepicker-birthdate" value="{{ $value }}"/>
        <a href="javascript:void(0);" @if($resultId) id="{{ $resultId }}" @endif
           class="datepicker-birthdate_result">{{ $resultText }}</a>
    </div>

@elseif($floating)

    <div {{ $attributes->merge(['class' => 'text_input text_input--date']) }}
         data-datepicker="range"
         data-direction="{{ $direction }}"
         @if($container) data-container="{{ $container }}" @endif>
        <x-forms.text-input_fromLabel
            type="text"
            name="{{ $name }}"
            :placeholder="$placeholder"
            :value="$value"
            class="input date datepicker-input"
            readonly
        />
        <button type="button" class="datepicker-clear" aria-label="{{ __('Очистить даты') }}">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L9 9M9 1L1 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

@else

    {{-- пара полей: скрытое лежит прозрачным оверлеем поверх видимого
         и ловит клики (см. .date_input .datepicker-hidden в search.css) --}}
    <div {{ $attributes->merge(['class' => 'date_input']) }}
         data-datepicker="range"
         data-direction="{{ $direction }}">
        <input type="text" class="datepicker-range" value="{{ $display }}" readonly>
        <input type="text" class="datepicker-hidden" name="{{ $name }}" value="{{ $value }}"
               @if($maxSpan) data-max_span="{{ $maxSpan }}" @endif readonly>
    </div>

@endif
