<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

    {{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_admin_menu')


    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Редактирование') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Измените персональные балла и кешбэк. Бонусы обновляются автоматически.')}}</span></div>
    </div>


@include('dashboard.forms.edit_profile_admin_user_balls')

</div>





