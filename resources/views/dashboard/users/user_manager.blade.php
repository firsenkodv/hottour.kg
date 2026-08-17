<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

    {{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_admin_menu')


    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Закрепление менеджера') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Возможность перезакрепления менеджера за пользователем.')}}</span></div>
    </div>


@include('dashboard.forms.edit_profile_admin_user_for_manager')

</div>





