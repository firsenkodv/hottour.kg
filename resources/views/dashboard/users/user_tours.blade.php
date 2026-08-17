
<div class="dashboardBox dashboardBox__a_user ">

{{--    {{ /* данные просматриваемого юзера */ }}--}}
    @include('dashboard.users.user_mini_data')

{{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_admin_menu')

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Туры пользователя') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Список закрепленных туров за ') }} {{$item->name}}</span></div>
    </div>


    <div class="crm" data-user="{{$item->id}}">
        @if($tours)
        @foreach($tours as $tour)

            <div class="crm__item t_item">
                <div class="t_item__top flex">
                    <div class="t_item__top_left"><span class="t_country">{{ $tour['to'] }}</span>
                        @if($tour['info'])
                            <span class="textnohtml_absol textnohtml_rel"><i style="display: none;">{{ $tour['info'] }}<pr class="b__close">×</pr></i></span>
                        @endif
                    </div>
                    <div class="t_item__top_right"><span
                            class="t_pay">{{ $tour['statusname'] }}</span></div>
                </div>
                <div class="t_item__center flex">
                    <div class="t_item__center_left">
                        <div class="t_city"><span class="t_city__label">{{__('Город вылета:')}}</span>
                            <span class="t_city__city">{{ $tour['from'] }}</span>
                        </div>
                        <div class="t_dates">
                            <div class="t_from">{{__('Вылет:')}} <span>{{ rusdate3($tour['datebeg']) }}</span>
                            </div>
                            <div class="t_to">{{ __('Прилет:') }}
                                <span>{{ rusdate3($tour['dateend']) }}</span></div>
                            <div class="t_night">{{ __('Ночей:') }}
                                <span>{{ $tour['nights'] }}</span></div>
                        </div>
                        <div class="t_hotel"><span
                                class="t_hotel__label">{{__('Отель:')}}</span><span
                                class="t_hotel__mane">{{ $tour['hotelname'] }}</span></div>
                    </div>
                    <div class="t_item__center_right">


                        <div
                            class="t_price">{{ price($tour['summ']) }} {{currency($tour['currencyname'])}}</div>

                    </div>
                </div>
                <div class="t_item__bottom flex">
                    <div class="t_item__bottom_left">
                        <div class="t_dog" data-contract="{{$tour['id']}}">Договор № <span
                                class="t_dog__number">{{$tour['number']}}</span> от <span
                                class="t_dog__date">{{ $tour['signaturedate22'] }}</span> {!!  $tour['podpis'] !!}
                        </div>
                    </div>
                    <div class="t_item__bottom_right">
                        <div class="t_pdficon">
                            <a download=""
                               href="{{ asset(Storage::disk('user')->url('/contract/hottour.pdf')) }}">{{__('Общие условия договора')}}</a>
                        </div>
                    </div>
                </div>
                <div class="t_line_crm"></div>

            </div>

        @endforeach
        @else
            <h3 class="F_h1 pad_t1_important noresult">{{ __('Нет результатов') }}</h3>
        @endif

    </div>


</div>

