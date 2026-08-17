<div class="checkbox_choice hotel_ch">
    <div class="checkbox_choice__name">
        <div class="checkbox_choice__name__flex flex">
       {{--     <span>{{ __('Отель') }}</span>--}}
            <input type="text" id="filter_jq" placeholder="{{ __('Отель') }}" class="filter_jq">

            <div class="s_hotelparams">
                <a href="#hotelpamams" data-fancybox>{{ __('Параметры отелей') }}</a>
            </div>
        </div>
    </div>
    <div class="scroll-block" id="hotels-area">
        <x-forms.loader class="br_12"/>
    </div>
</div>
