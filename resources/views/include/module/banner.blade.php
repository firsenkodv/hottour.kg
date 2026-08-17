<div class="swiper swiper_banner">
    <div class="swiper-wrapper slick_slider__bannercarusel">

        <div class="swiper-slide">
        <div class="b_banner  b_banner_1" style="background-image: url('{{ Storage::url('/images/baner/samolet_new.jpg') }}'); background-repeat: no-repeat; background-size: cover;      background-position: center; ">
            <div class="b_banner__1000 b_banner__800">
                <div class="b_banner__left">

                </div>
                <div class="b_banner__right">
                <div class="b_banner__right_flex">
                <div class="b_banner__right_flex__left">
                    <span class="h2 ">Горящие туры</span>
                    <span class="s_p"><span class="swiper-no-swiping">Турция, ОАЭ, Египет</span></span>
                </div>
                    <div class="b_banner__right_flex__right">
                    <div class="b_banner__right_bottom"><a href="#pick_tour" data-country="Египет" data-fancybox="" class="pick_tour_button_js button button_normal  pad_r16_important pad_l16_important">Подобрать <span class="tur">тур</span></a></div>
                    </div>
                </div>
                    </div>
            </div>
        </div>
        </div>

        <div class="swiper-slide">
            <div class="b_banner b_banner_2" style="background-image: url('{{ Storage::url('/images/baner/samolet_new2.jpg') }}'); background-repeat: no-repeat; background-size: cover ">
                <div class="b_banner__1000 b_banner__800">
                    <div class="b_banner__left">

                    </div>
                    <div class="b_banner__right">

                        <div class="b_banner__right_flex">
                            <div class="b_banner__right_flex__left">
                                <span class="h2 ">Рассрочка</span>
                                <span class="s_p"><span class="swiper-no-swiping">Отдыхай сейчас</span></span>
                            </div>
                            <div class="b_banner__right_flex__right">
                                <div class="b_banner__right_bottom"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="b_banner  b_banner_3" style="background-image: url('{{ Storage::url('/images/baner/samolet_new3.jpg') }}'); background-repeat: no-repeat; background-size: cover ">
                <div class="b_banner__1000 b_banner__800">
                    <div class="b_banner__left">

                    </div>
                    <div class="b_banner__right">

                        <div class="b_banner__right_flex">
                            <div class="b_banner__right_flex__left">
                                <span class="h2 ">Наш Телеграм</span>
                                <span class="s_p"><span class="swiper-no-swiping"><a target="_blank" href="{{ (isset($setting['telegram']))? $setting['telegram'] : ''  }}">@hottour.kz</a></span></span>
                            </div>
                            <div class="b_banner__right_flex__right">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="block">
        <div class="b_nav">
            <button type="button" class="swiper-prev swiper-button-prev-swiper_banner click_slider_p__js"><span>‹</span></button>
            <button type="button" class="swiper-next swiper-button-next-swiper_banner click_slider_n__js"><span>›</span></button>
        </div>
    </div>
</div>
