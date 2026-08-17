<div class="hbox__middle country_page ">

    @if($hotel->desc)
        <div class="philosopher hotel__placement desc">{!!  $hotel->desc !!} </div>
    @endif


    <div class="hotel__services">
        <h3>{{__('Удобства и услуги')}}</h3>
    </div>

    <div class="servise_item hotel_build"><h4>{{__('Отель')}} <span>{{  $hotel->title }}</span></h4>

        @if($hotel->build)
            <div class="desc">
                <ul>
                    <li>год строительства: {{  $hotel->build }}

                        @if($hotel->repair)
                            , ремонт: {{ $hotel->repair }}
                        @endif
                    </li>
                    @if($hotel->repair)
                        <li>площадь: {{ $hotel->repair }} </li>
                    @endif

                </ul>
            </div>
        @endif

    </div>


    @if($hotel->territory)

        <div class="servise_item hotel_territory"><h4>{{ __('Территория') }}</h4>
            <div class="desc">
                {!!  $hotel->territory !!}
            </div>
        </div>
    @endif

    @if($hotel->roomtypes)

        <div class="servise_item hotel_roomtypes"><h4>{{  __('Номер') }}</h4>
            <div class="desc">
                {!!  $hotel->roomtypes !!}
            </div>
        </div>
    @endif

    @if($hotel->inroom)

        <div class="servise_item hotel_inroom"><h4>{{ __('В номере') }}</h4>
            <div class="desc">
                {!!  $hotel->inroom !!}
            </div>
        </div>
    @endif

    @if($hotel->child)

        <div class="servise_item hotel_child"><h4>{{ __('Для детей') }}</h4>
            <div class="desc">
                {!! $hotel->child !!}
            </div>
        </div>
    @endif


    @if($hotel->servicefree)

        <div class="servise_item hotel_servicefree"><h4>{{ __('Бесплатно') }}</h4>
            <div class="desc">
                {!! $hotel->servicefree !!}
            </div>
        </div>
    @endif


    @if($hotel->servicepay)

        <div class="servise_item hotel_servicepay"><h4>{{ __('Платно') }}</h4>
            <div class="desc">
                {!! $hotel->servicepay !!}
            </div>
        </div>
    @endif


</div>

