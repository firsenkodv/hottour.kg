@props([
    'more' => 'Читать далее',
    'less' => 'Свернуть',
])

{{--
    Сворачивает содержимое до первого абзаца, остальное раскрывается по кнопке.
    Высоту считает JS (resources/js/include/desc-collapse.js):
    без JS кнопка скрыта, текст виден целиком. Перенесено из hseipaa.kz.
--}}
<div class="desc-collapse"
     data-desc-collapse
     data-label-more="{{ $more }}"
     data-label-less="{{ $less }}">

    <div class="desc-collapse__body" data-desc-collapse-body>
        {{ $slot }}
    </div>

    <button class="desc-collapse__btn" type="button" data-desc-collapse-btn aria-expanded="false" hidden>
        <span data-desc-collapse-label>{{ $more }}</span>
        <svg class="desc-collapse__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>
</div>
