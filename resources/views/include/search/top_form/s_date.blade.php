<div class="s_date s_block__3">
    <div class="s_date__label s_label">{{ __('Интервал дат вылета') }}</div>
    <x-forms.datepicker
        name="daterange"
        mode="range"
        display="{{ rusdate(strtotime($daterange[0])) }} - {{ rusdate(strtotime($daterange[1])) }}"
        value="{{ date('d.m.Y', strtotime($daterange[0])) }} - {{ date('d.m.Y', strtotime($daterange[1])) }}"
        :max-span="13"
    />
</div>
