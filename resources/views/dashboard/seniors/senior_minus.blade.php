<div class="dashboardBox dashboardBox__a_user ">
    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')


    {{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_senior_menu')

    <div class="c__title_subtitle pad_t21_important">
        <h3 class="F_h1">{{ __('Менеджеры!') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Команда менеджера. Руководителя отдела продаж - ')}} <b>{{ $item->name }}</b></span></div>
    </div>

   @include('dashboard.forms.edit_senior_managers_minus')

</div>




