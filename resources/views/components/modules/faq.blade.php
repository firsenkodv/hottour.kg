@props(['items' => [], 'pageItems' => []])

@php
    /**
     * Json-поле «Вопрос/Ответ» в админке почти всегда содержит мусорные строки:
     * блок добавили и не заполнили, пару добавили и оставили пустой. Раньше такие
     * записи доезжали до вёрстки как <details></details> — браузер рисует его
     * своим заголовком «Сведения», — и как пустая <section class="faq"> с отступами.
     *
     * Поэтому чистим данные до вывода: пара живёт, только если заполнен вопрос
     * (без него у аккордеона нет заголовка), блок — только если в нём осталась
     * хоть одна пара, секция — только если остался хоть один блок.
     */
    $faqBlocks = collect($items ?: $pageItems)
        ->map(fn ($block) => [
            'title'   => trim((string) data_get($block, 'title', '')),
            'options' => collect(data_get($block, 'options', []))
                ->filter(fn ($qa) => trim((string) data_get($qa, 'question', '')) !== '')
                ->values(),
        ])
        ->filter(fn ($block) => $block['options']->isNotEmpty())
        ->values();
@endphp

@if($faqBlocks->isNotEmpty())
    <section class="faq" id="faq">
        <div class="container faq__content">

            @foreach($faqBlocks as $block)
                @if($block['title'] !== '')
                    <h2>{{ $block['title'] }}</h2>
                @endif

                <div class="faq-list">
                    @foreach($block['options'] as $index => $qa)
                        <details {{ $index === 0 ? 'open' : '' }}>
                            <summary>{{ data_get($qa, 'question') }}</summary>

                            @if(filled(data_get($qa, 'answer')))
                                <div>{!! data_get($qa, 'answer') !!}</div>
                            @endif
                        </details>
                    @endforeach
                </div>
            @endforeach

        </div>
    </section>
@endif
