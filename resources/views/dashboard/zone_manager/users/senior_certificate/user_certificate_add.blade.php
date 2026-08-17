<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

    {{--    {{ /* МЕНЕДЖЕР !!!меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_manager_menu')

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Добавление сертификата') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Добавление сертификата пользователю - ')}}<b>{{ $item->name }}</b></span>
        </div>
    </div>

    <div class="page_important page_sertificate">

    @include('dashboard.forms.add_certuficate_user')

    </div>

</div>

