<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')
    <br>
    <hr>
    <div class="c__title_subtitle pad_t21_important">
        <h3 class="F_h1">{{ __('Внимание!') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Это редактирование данных менеджера, для показа клиентам этого менеджера.')}}</span></div>
    </div>
    @include('dashboard.forms.edit_profile_admin_manager')


</div>


