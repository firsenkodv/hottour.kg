<div class="v_vid">
    <div class="v_vid__block">
        <div class="h2">{{__('Почему выбирают нас?')}}</div>

    </div>

    <div class="v_vid__wrapper">
        <div class="v_vid__video">
            <video controls width="100%" height="484" preload="none"  poster="{{ asset('/video/poster.jpg') }}" onclick="this.play();">
                <source src="{{ asset('/video/hottour.mp4') }}" type="video/mp4">
                Ваш браузер не поддерживает встроенные видео :(
            </video>
         </div>

        <div class="v_vid__flickity">
            <div class="w_25 flex v_vid__item">
                <div class="v_img w_30">
                    <img alt="Удобно" width="44" height="44" loading="lazy" src="{{ asset('images/inline/include-module-index-video-1.svg') }}">
                </div>
                <div class="w_70">
                    <span class="v_h3">{{ __('Удобно') }}</span>
                    <p>{{ __('Не тратьте драгоценное
                        время на дорогу
                        и пробки') }}</p>
                </div>
            </div>
            <div class="w_25 flex v_vid__item">
                <div class="v_img w_30">
                    <img alt="Надежно" width="34" height="40" loading="lazy" src="{{ asset('images/inline/include-module-index-video-2.svg') }}">
                </div>
                <div class="w_70">
                    <span class="v_h3">{{ __('Надежно') }}</span>
                    <p>{{ __('Все транзакции
                        и сделки защищены') }}</p>
                </div>
            </div>
            <div class="w_25 flex v_vid__item">
                <div class="v_img w_30">
                    <img alt="Быстро" width="40" height="40" loading="lazy" src="{{ asset('images/inline/include-module-index-video-3.svg') }}">
                </div>
                <div class="w_70">
                    <span class="v_h3">{{ __('Быстро') }}</span>
                    <p>{{ __('Деньги и информация
                        поступает моментально') }}</p>
                </div>
            </div>
            <div class="w_25 flex v_vid__item">
                <div class="v_img w_30">
                    <img alt="Совремнно" width="34" height="40" loading="lazy" src="{{ asset('images/inline/include-module-index-video-4.svg') }}">
                </div>
                <div class="w_70">
                    <span class="v_h3">{{ __('Современно') }}</span>
                    <p>{{ __('Электронный документ') }}</p>
                </div>
            </div>
        </div><!--.v_vid__flickity-->


    </div>
</div>
