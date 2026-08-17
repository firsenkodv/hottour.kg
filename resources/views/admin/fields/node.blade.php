<x-moonshine::layout.grid>
    <x-moonshine::layout.column adaptiveColSpan="4" colSpan="4">
        <x-moonshine::layout.box :dark="true" title="Первый">
            {{ __('Смена средства связи, только после НАЖАТИЯ на ссылку. Остальные средства связи не меняются.') }}
        </x-moonshine::layout.box>
    </x-moonshine::layout.column>

    <x-moonshine::layout.column adaptiveColSpan="4" colSpan="4">
        <x-moonshine::layout.box :dark="true" title="Второй">
            {{ __('Смена всех средств связи через каждый день начиная с 00 часов, по выставленному на сервере времени.') }}
        </x-moonshine::layout.box>
    </x-moonshine::layout.column>

    <x-moonshine::layout.column adaptiveColSpan="4" colSpan="4">
        <x-moonshine::layout.box :dark="true" title="Третий">
            {{ __('Показ выставленных средств связи, без изменений.') }}
        </x-moonshine::layout.box>
    </x-moonshine::layout.column>
</x-moonshine::layout.grid>
