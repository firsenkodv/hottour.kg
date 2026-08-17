<div class="mob_menu_content">

    <div class="mob_menu_content_absol">
        <div class="m_m_cont_top m_m_cont_top1">
            <span class="m_m_top_label">{{ __('Меню') }}</span>
            <span class="m_m_top_close"></span>
        </div>
        <div class="m_m_cont_top m_m_cont_top2">
        <span class="m_m_top_lang">
            <x-language.header-language-component/>
        </span><!--.m_m_top_lang-->
        </div>
        <div class="fMenu tab_plane" data-mf="m_f3">
            @include('html.mobile._partial.mobile_menu')
        </div>
        <div class="fSearch tab_plane" data-mf="m_f1">
            @include('include.search.index_search_old')

        </div>
        <div class="fContacts tab_plane" data-mf="m_f4">
            <div class="contact_mobilie">
            @include('include.connect._change_contacts')
            </div>

        </div>
        <div class="fLogin tab_plane" data-mf="m_f5">
            @auth()
                @php
                    $user = auth()->user();
                @endphp
                @include('dashboard.left_bar.avatar', ['user' => $user])
                <div class="c__title_subtitle">
                    <h3 class="F_h1 left_bar__name" title="{{ $user->name }}">{{ $user->name }}</h3>
                    <div class="F_h2 left_bar__email pad_t5"><span>{{ $user->email }}</span></div>
                    @if($user->phone)
                        <div class="left_bar__phone pad_t10"><span>{{ format_phone($user->phone) }}</span></div>
                    @endif
                    <ul>
                        <li><a class="{{ active_linkMenu(asset(route('cabinet'))) }}" href="{{ asset(route('cabinet')) }}">{{__('Мои туры')}}</a></li>
                        <li><a class="{{ active_linkMenu(asset(route('setting')), 'find') }}"  href="{{ asset(route('setting')) }}">{{__('Настройки')}}</a></li>
                        <li>
                            <x-forms.auth-form_mob2
                                action="{{ route('logout') }}"
                                method="POST">
                                <button type="submit" class="enter_to_website__a2 enter_to_website__a2__mob"><span
                                        class="sp__kab">
                                        {{__('Выход')}}
                                        <img alt="" src="{{ asset('images/inline/html-mobile-bottom-1.svg') }}">
                                    </span></button>
                            </x-forms.auth-form_mob2>
                        </li>
                    </ul>
                </div>

            @endauth

            @guest()
                @include('auth.forms.f-login')
            @endguest
        </div>

    </div>


</div><!--.mob_menu_content-->

<div class="mobile_menu">
    <div class="mob_flex">
        <div class="m_f m_f1" data-mf="m_f1">
            <div class="m_img"></div>
            <span>{{ __('Поиск') }}</span>
        </div>
        <a class="m_f m_f2 {{ active_linkMenu(asset(route('home'))) }} " href="/">
            <div class="m_img"></div>
            <span>{{ __('Главная') }}</span>
        </a>
        <div class="m_f m_f3"  data-mf="m_f3">
            <div class="m_img"></div>
            <p>{{ __('Меню') }}</p>
        </div>
        <div class="m_f m_f4"  data-mf="m_f4">
            <div class="m_img"></div>
            <span>{{ __('Контакты') }}</span>
        </div>
        <div class="m_f m_f5"  data-mf="m_f5">
            <div class="m_img"></div>
            <p>{{ __('Кабинет') }}</p>
        </div>


    </div>
</div>
