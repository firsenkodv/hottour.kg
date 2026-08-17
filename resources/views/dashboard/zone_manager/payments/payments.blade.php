<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

    {{--    {{ /* МЕНЕДЖЕР !!!меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_manager_menu')

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Платежи') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Завершенные платежи пользователя.')}}</span></div>
    </div>


    @if(count($payments))
        <div class="dashboardBox pad_t9">

            <div class="dashboardBox__title">
                <div class="a_user__row a_user">
                    <div class="a_user__name">
                        {{ __('Имя, договор') }}
                    </div>
                    <div class="a_user__email">
                        {{ __('Сумма, дата') }}
                    </div>

                    <div class="a_user__personal_nolink">
                        {{ __('Статус, номер') }}
                    </div>
                </div>

            </div>

            @foreach($payments as $payment)
                <div class="dashboardBox__a_users a_users ">

                    <div class="a_user__row a_user
            @if($payment->order_status == 2) background_green @else background_alert   @endif">
                        <div class="a_user__name">
                            <div class="a_user__nameFio">
                                <div class="a_user__left">
                                    {{ $item->name }}
                                </div>
                            </div>
                            <div class="a_user__nameBirthdate color_grey color_grey_12">{{ $payment->desc }}</div>

                        </div>
                        <div class="a_user__email">
                            <div class="a_user__nameFio">{{ price($payment->amount) }} {{ config('currency.currency.KZT') }}</div>
                            <div class="a_user__nameBirthdate color_grey color_grey_12">{{ rusdate4($payment->created_at) }}</div>
                        </div>

                        <div class="a_user__flex_direction">
                            <div class="">{{ $payment->status }}</div>
                            <div class="a_user__nameBirthdate color_grey color_grey_12">№ {{ $payment->order_number }}</div>

                        </div>


                    </div>

                </div>
            @endforeach


        </div>
        {{ $payments->withQueryString()->links('pagination::default') }}
    @endif




</div>


