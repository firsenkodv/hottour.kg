@php
    /**
     * v2 обращался к объекту поля ($element->phone и т.д.).
     * В v4 данные приходят из StatisticWeek::viewData().
     */
    $blocks = [
        ['Телефон', 'phone', $phone, $phone_result],
        ['WhatsApp', 'whatsapp', $whatsapp, $whatsapp_result],
        ['Telegram', 'telegram', $telegram, $telegram_result],
    ];
@endphp

<x-moonshine::layout.grid>
    @foreach($blocks as [$title, $key, $rows, $counts])
        <x-moonshine::layout.column adaptiveColSpan="4" colSpan="4">
            <x-moonshine::layout.box :dark="true" :title="$title">
                @if($rows)
                    <x-moonshine::collapse title="Скрыть / Показать" :open="true">
                        @foreach($counts as $value => $amount)
                            <strong>{{ $value }} - {{ $amount }}</strong> ({{ __('К-во нажатий') }}) <br>
                            @if(! $loop->last)
                                <x-moonshine::layout.divider/>
                            @endif
                        @endforeach
                    </x-moonshine::collapse>

                    @foreach($rows as $row)
                        {{ $row[$key] }} - {{ rusdate4($row['created_at']) }} <br>
                    @endforeach
                @else
                    {{ __('Нет данных за выбранный периуд') }}
                @endif
            </x-moonshine::layout.box>
        </x-moonshine::layout.column>
    @endforeach
</x-moonshine::layout.grid>
