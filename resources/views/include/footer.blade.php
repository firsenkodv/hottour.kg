<footer class="background_292F3D">
    <div class="block">
        <div class="f_flextop">
            <div class="f_flextop__left">
                <div class="fl_1 f_logo">
                    <x-logo.logo-footer
                        class="footer_logo"
                        width="260"
                        height="59"
                        alt="Footer Logo Hottour"
                    />
                    <div class="f_contact">
                    <div class="f_contact__label">
                        {{ __('Связь с нами в один клик') }}
                    </div>
                    <div class="f_contact__phone">
                        {!! (isset($setting['phone2']))? $setting['phone2'] : '' !!}
                    </div>
                    <div class="f_contact__label_address">
                        {{ __('  Фактический адрес') }}
                    </div>

                    <div class="f_contact__address">
                        <div>{!! (isset($setting['idn']))? $setting['idn'] : '' !!}</div>
                        <div>{!! (isset($setting['country']))? $setting['country'] : ''  !!}</div>
                        <div>{!! (isset($setting['sityAddress']))? $setting['sityAddress'] : '' !!}</div>
                        <div style="padding: 10px 0 0 0">{!! (isset($setting['bin']))? $setting['bin'] : '' !!}</div>
                        <div>{!! (isset($setting['company_name']))? $setting['company_name'] : '' !!}</div>
                    </div>

                    </div>


                </div>
                <div class="fl_2 f_menus">

                    <div class="f1 ff">
                        <div class="h4"><a href="{{ route('about') }}">{{ __('О нас') }}</a></div>
                        <ul class=" nav menu mod-list">

                        @foreach($top_menudump2s as $menu)
                            <li class="{{ active_linkMenu(asset(config('links.link.dump2'). '/' . $menu['slug']), 'find') }}"><a href="{{ asset(config('links.link.dump2'). '/' . $menu['slug'])  }}">{{ $menu['title']  }}</a></li>
                        @endforeach
                        </ul>
                    </div>

                    <div class="f2 ff">
                        <div class="h4">{{__('Туры')}}</div>
                        <ul class=" nav menu mod-list">
                            @foreach($top_menutours as $menu)
                                <li class="{{ active_linkMenu(asset(config('links.link.tours'). '/' . $menu['slug']), 'find') }}"><a href="{{ asset(config('links.link.tours'). '/' . $menu['slug'])  }}">{{ $menu['title']  }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="f3 ff">
                        <div class="h4">{{__('Полезное')}}</div>
                        <ul class=" nav menu mod-list">
                            @foreach($top_menudumps as $menu)
                                <li class="{{ active_linkMenu(asset(config('links.link.dump'). '/' . $menu['slug']), 'find') }}"><a href="{{ asset(config('links.link.dump'). '/' . $menu['slug'])  }}">{{ $menu['title']  }}</a></li>
                            @endforeach
                        </ul>

                    </div>

                </div>
            </div>
            <div class="f_flextop__right">
                <div class="fr_1 f_social">
                    <div class="f_social__top">
                    <div class="f_social__label">
                        {{__('Мы в социальных сетях')}}
                    </div>
                    @include('include.icons.top_social_big')
                    </div>
                    <div class="f_social__bottom">
                    <div class="f_social__mobileapp">
                        {{__('Скачайте наше мобильное приложение')}}
                    </div>
                    <x-mobile_app.mobile_app
                        width="141"
                        height="40"
                    />
                        <div class="">

                            <img alt="master cart" width="40" height="30" src="{{ asset('images/inline/include-footer-1.svg') }}">
                            <img alt="visa" width="70" height="30" src="{{ asset('images/inline/include-footer-2.svg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="f_flexbottom">
            <div class="copyright">© 1993 - {{ date("Y") }} HOT TOUR - ХОТ ТУР</div>
            <div class="sign_the_contract">
                <a style="padding-right: 8px" href="/o-nas/dokumenty/rekvizity">Все реквизиты</a>
                <a style="padding-right: 8px"  href="/o-nas/dokumenty/polzovatelskoe-soglashenie">Пользовательское соглашение</a>
                <a href="/o-nas/dokumenty/privacy">Политика конфиденциальности</a>
            </div>

        </div>
    </div>
</footer>
