<div class="hbox__submenu hbox__submenuBorder">
    <div class="view_subcategories_countries v_s_c ">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.manager_ToursUser.user', ['id'=> $item->id])))  }}"><a href="{{asset(route('page.manager_ToursUser.user', ['id'=> $item->id])) }}">{{ __('Туры') }}</a></div>

            <div class="v_s_c__item {{ active_linkMenu(route('page.manager_UsersCertificates.user', ['id' => $item->id]), 'find')  }}"><a href="{{asset(route('page.manager_UsersCertificates.user', ['id' => $item->id]))}}">{{ __('Сертификаты') }}</a></div>

            <div class="v_s_c__item {{ active_linkMenu(route('page.manager_UsersPageUser', ['id' => $item->id]))  }}">
                <a href="{{asset(route('page.manager_UsersPageUser', ['id' => $item->id])) }}">{{ __('Настройки') }}</a></div>

            @if(role($user->id) == 'senior')
                <div class="v_s_c__item {{ active_linkMenu(asset(route('page.ball.user', $item->id)))  }}"><a href="{{ asset(route('page.ball.user', $item->id)) }}">{{ __('Баллы') }}</a></div>

            @endif
            <div class="v_s_c__item {{ active_linkMenu(route('page.manager_UsersPagePayment', ['id' => $item->id]))  }}">
                <a href="{{asset(route('page.manager_UsersPagePayment', ['id' => $item->id])) }}">{{ __('Платежи') }}</a></div>

        </div>
        <div class="view_subcategories_countries__mobile menu_cab_m__js"></div>

    </div>
</div>

