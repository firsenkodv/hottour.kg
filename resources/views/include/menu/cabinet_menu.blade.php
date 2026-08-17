<div class="hbox__submenu">
    <div class="view_subcategories_countries v_s_c ">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item {{ active_linkMenu(asset(route('cabinet')))  }}"><a href="{{ route('cabinet') }}">{{ __('Туры') }}</a>
            </div>

            <div class="v_s_c__item {{ active_linkMenu(asset(route('certificate')), 'find')  }}"><a href="{{ route('certificate') }}">{{ __('Сертификаты') }}</a></div>

            @if(role($user->id) == 'user')
            <div class="v_s_c__item {{ active_linkMenu(asset(route('favorites_user')), 'find')  }}"><a href="{{ route('favorites_user') }}">{{ __('Избранное') }}</a></div>
            @endif

            <div class="v_s_c__item {{ active_linkMenu(asset(route('important')), 'find')  }}"><a href="{{ route('important') }}">{{ __('Важное') }}</a></div>

            <div class="v_s_c__item {{ active_linkMenu(asset(route('setting')))  }}"><a href="{{ route('setting') }}">{{ __('Настройки') }}</a></div>

            @if(role($user->id) == 'admin')
            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.edit')), 'find')  }}"><a href="{{ route('page.edit') }}">{{ __('Редактор') }}</a></div>

            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.users')), 'find')  }}"><a href="{{ route('page.users') }}">{{ __('Пользователи') }}</a></div>

            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.managers')), 'find')  }}"><a href="{{ route('page.managers') }}">{{ __('Менеджеры') }}</a></div>

            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.seniors')), 'find')  }}"><a href="{{ route('page.seniors') }}">{{ __('РОП') }}</a></div>
            @endif

            @if(role($user->id) == 'manager')
                <div class="v_s_c__item v_s_c__item__manager {{ active_linkMenu(asset(route('page.manager_Users')), 'find')  }}"><a href="{{ route('page.manager_Users') }}">{{ __('Пользователи') }}</a></div>
            @endif

            @if(role($user->id) == 'senior')
                <div class="v_s_c__item v_s_c__item__manager {{ active_linkMenu(asset(route('page.manager_Users')), 'find')  }}"><a href="{{ route('page.manager_Users') }}">{{ __('Пользователи') }}</a></div>

                <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.senior_Managers')), 'find')  }}"><a href="{{ route('page.senior_Managers') }}">{{ __('Менеджеры') }}</a></div>
            @endif

            @if(role($user->id) == 'admin' || role($user->id) == 'manager' || role($user->id) == 'senior')
            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.contracts')), 'find')  }}"><a href="{{ route('page.contracts') }}">{{ __('Договоры') }}</a></div>
            @endif

            @if(role($user->id) == 'user')
            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.user_contracts')), 'find')  }}"><a href="{{ route('page.user_contracts') }}">{{ __('Договоры') }}</a></div>
            @endif

            <div class="v_s_c__item v_s_c__item__admin {{ active_linkMenu(asset(route('page.payment')), 'find')  }}"><a href="{{ route('page.payment') }}">{{ __('Оплата') }}</a></div>

            {{-- Кнопка "ещё" — последний flex-элемент, прижата вправо через margin-left:auto --}}
            <div class="v_s_c__more">
                <button class="v_s_c__more-btn" type="button" aria-label="{{ __('Ещё пункты') }}">
                    <svg width="20" height="4" viewBox="0 0 20 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2" cy="2" r="2" fill="#282828"/>
                        <circle cx="10" cy="2" r="2" fill="#282828"/>
                        <circle cx="18" cy="2" r="2" fill="#282828"/>
                    </svg>
                </button>
                <div class="v_s_c__more-dropdown"></div>
            </div>

        </div>
        <div class="view_subcategories_countries__mobile menu_cab_m__js"></div>

    </div>
</div>
