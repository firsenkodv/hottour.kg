<div class="hbox__submenu hbox__submenuBorder">
    <div class="view_subcategories_countries v_s_c ">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.users').'/user/'.$item->id.'/tours'))  }}"><a href="{{asset(route('page.users').'/user/'.$item->id.'/tours') }}">{{ __('Туры') }}</a></div>

            <div class="v_s_c__item {{ active_linkMenu(route('page.certificates.user', ['id' => $item->id]), 'find')  }}"><a href="{{asset(route('page.certificates.user', ['id' => $item->id]))}}">{{ __('Сертификаты') }}</a></div>


            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.users').'/user/'.$item->id.'/setting'))  }}"><a href="{{asset(route('page.users').'/user/'.$item->id.'/setting') }}">{{ __('Настройки') }}</a></div>


            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.users').'/user/'.$item->id.'/manager'))  }}"><a href="{{asset(route('page.users').'/user/'.$item->id.'/manager') }}">{{ __('Менеджер') }}</a></div>

            <div class="v_s_c__item {{ active_linkMenu(asset(route('page.ball.user', $item->id)))  }}"><a href="{{ asset(route('page.ball.user', $item->id)) }}">{{ __('Баллы') }}</a></div>


        </div>
        <div class="view_subcategories_countries__mobile menu_cab_m__js"></div>

    </div>
</div>
