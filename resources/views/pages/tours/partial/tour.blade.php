<div class="hbox temp_img_tree tour_data__hotels">
<div class="hrow">
    @foreach($item->params as $p_item)

        <div class="hcol">
            <div class="pc_tree">

                    @if($p_item['hotelpicture'])
                        {{-- remote_image: фото с static.tourvisor.ru, при выключенном
                             сервисе (локаль под VPN) отдаёт заглушку --}}
                        <img class="pc_category_img" width="280" height="200" loading="lazy" title="{{$p_item['hotelname']}}" src="{{ remote_image(asset($p_item['hotelpicture'])) }}"
                             alt="{{$p_item['hotelname']}}">
                    @else
                        <div
                            style="
                            width: 280px;
                            height: 200px;
                            background-size: 70%;
                            background-color: #EF533F;
                            background-position: 38px 30px;
                            border-radius: 12px;
                            background-repeat: no-repeat;
                            background-image: url('{{ asset('images/inline/html-modals-gr-1.svg') }}');"
                        ></div>
                    @endif
                    <h3 title="{{$p_item['hotelname']}}">{{$p_item['hotelname']}}</h3>
                    <div class="hcolNoImg__smalltext colorGrey">
                        <div class="hot_item__date ">
                            {{$p_item['nights']}} ночей
                            @if($p_item['meal'])
                                ・{{ $p_item['meal'] }}
                            @endif
                            @if($p_item['flydate'])
                                ・Вылет {{ $p_item['flydate'] }}
                            @endif
                        </div>
                    </div>

                        <div class="hot_item__odred h_order flex ">
                            <div class="hot_item__price">
                                <div
                                    class="priceold">{{ price($p_item['priceold']) }}
                                    <span>{{ currency($p_item['currency']) }}</span>
                                </div>

                                     {{ price($p_item['price']) }}

                                     <span>{{ currency($p_item['currency']) }}</span>


                            </div>
                            <div class="hot_item__button">
                                <a href="#reserve_hotel" data-fancybox data-tout_data='{"price":"{{number_format($p_item['price'], 0, '', ' ')}}", "dateFrom":"{{rusdate2($p_item['flydate'])}}", "dateTo":"{{rusdate2(date('d.m.Y', strtotime('+'. $p_item['nights'] .' days', strtotime($p_item['flydate']))))}}", "nights":"{{$p_item['nights']}}", "room":"", "mealrussian":"", "meal":"{{ $p_item['meal'] }}", "adults":"1", "child":"0", "tourname":"", "sity":"{{ getDepartureName($item->city)  }}","hotel":"{{ $p_item['hotelname']}}","country":"{{ $p_item['countryname']}}","stars":"{{ $p_item['hotelstars']}}","operatorname":"{{ $p_item['operatorname']}}", "hotelregionname" : "{{$p_item['hotelregionname']}}", "currency":"{{ currency($p_item['currency']) }}"}' class="button button_normal tour_button_js">
                                    {{__('Посмотреть')}}
                                </a>
                            </div>
                        </div>

            </div>
        </div>
    @endforeach
</div>
</div>
