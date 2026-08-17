<div class="p_plane">
    <div class="p_plane__flex">
        <div class="p_plane__left">
            @include('html.temp_forms.order_mini')
        </div>
        <div class="p_plane__right">

            <div class="mod_hot_fly_list">
                <div class="flex mod_hot_fly_option pad_b30">
                    <div class="mod_hot_fly_option_left w_15 pad_t15">
                        <img alt="plane1" width="40" height="40" loading="lazy"
                             src="{{ asset('images/inline/include-module-plane-1.svg') }}">
                    </div>
                    <div class="mod_hot_fly_option_right w_75">
                        <span class="f_h3">{{ __('Подбор') }}</span>
                        <p>{{ __('Выберите тур на сайте или позвоните менеджеру он поможет') }}</p>
                    </div>
                </div><!--.axeld_flex mod_hot_fly_option-->

                <div class="flex mod_hot_fly_option  pad_b30">
                    <div class="mod_hot_fly_option_left w_15 pad_t15">
                        <img alt="plane2" width="37" height="40" loading="lazy"
                             src="{{ asset('images/inline/include-module-plane-2.svg') }}">
                    </div>
                    <div class="mod_hot_fly_option_right w_75 ">
                        <span class="f_h3">{{ __('Бронирование') }}</span>
                        <p>{{ __('Мы бронируем Вам тур, Вы производите полную оплату') }}</p>
                    </div>
                </div><!--.axeld_flex mod_hot_fly_option-->

                <div class="flex mod_hot_fly_option pad_b30">
                    <div class="mod_hot_fly_option_left w_15 pad_t15">
                        <img alt="plane3" width="40" height="30" loading="lazy"
                             src="{{ asset('images/inline/include-module-plane-3.svg') }}">
                    </div>
                    <div class="mod_hot_fly_option_right w_75">
                        <span class="f_h3">{{ __('Оплата') }}</span>
                        <p>{{ __('Online подпишите договор и сделайте предоплату по карте или в банке') }}</p>
                    </div>
                </div><!--.axeld_flex mod_hot_fly_option-->

                <div class="flex mod_hot_fly_option">
                    <div class="mod_hot_fly_option_left w_15 pad_t15">
                        <img alt="plane4" width="44" height="44" loading="lazy"
                             src="{{ asset('images/inline/include-module-plane-4.svg') }}">
                    </div>
                    <div class="mod_hot_fly_option_right w_75">
                        <span class="f_h3">{{ __('Отдыхаете') }}</span>
                        <p>{{ __('Вышлем готовые документы онлайн и Вы отправляетесь путешествовать') }}</p>
                    </div>
                </div><!--.axeld_flex mod_hot_fly_option-->

            </div>

        </div>
    </div>
</div>
