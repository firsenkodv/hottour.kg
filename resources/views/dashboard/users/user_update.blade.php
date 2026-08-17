<div class="dashboardBox dashboardBox__a_user ">

{{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

{{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_admin_menu')

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Редактирование') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Редактируйте внимательно. При изменении email внесите корректировки в CRM.')}}</span></div>
    </div>
    @include('dashboard.forms.edit_profile_admin_user')
    <hr>

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Изменить пароль') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Пароль минимум из пяти символов.')}}</span></div>
    </div>
    @include('dashboard.forms.edit_password', ['user'=>$item])


</div>

