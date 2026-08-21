<div class="ss_tours2__js">
    <div class="select_search_tours">
        <div class="sst_ sst_1 active" data-res="s_result_relative1"><span>Поиск туров</span></div>
        <div class="sst_ sst_2" data-res="s_result_relative2"><span>Отели</span></div>
        <div class="sst_ sst_3" data-res="s_result_relative3"><span>Авиабилеты</span></div>
    </div>
    <div class="s_result_ s_result_2">
        <div class="s_result_relative s_result_relative1 active">

            @if(config('tourvisor.module_search'))
            <div class="tv-search-form tv-moduleid-{{ config('tourvisor.module_search') }}"></div>
            @external('tourvisor_js')
                {{-- скрипт синхронный: при недоступном tourvisor.ru (VPN) вешает страницу --}}
                <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>
            @else
                <x-external.disabled service="Модуль поиска Tourvisor"/>
            @endexternal
            @endif

        </div><!--.s_result_relative-->
        <div class="s_result_relative s_result_relative2">
            @if(config('tourvisor.module_search'))
            <div class="tv-search-form tv-moduleid-{{ config('tourvisor.module_search') }}"></div>
            @external('tourvisor_js')
                <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>
            @else
                <x-external.disabled service="Модуль поиска Tourvisor"/>
            @endexternal
            @endif
        </div><!--.s_result_relative2-->
        <div class="s_result_relative s_result_relative3">
            {{--<script charset="utf-8" src="//www.travelpayouts.com/widgets/442012e76e971fa08683264f4368382f.js?v=2186" async></script>--}}
            @external('travelpayouts')
                <script async src="https://tp.media/content?currency=kzt&trs=145323&shmarker=140397&show_hotels=false&powered_by=false&locale=ru&searchUrl=avia.hottour.kz%2Fflights&primary_override=%23EF533F&color_button=%23EF533F&color_icons=%23EF533F&dark=%23282828&light=%23FFFFFF&secondary=%23FFFFFF&special=%23FFFFFf&color_focused=%23EF533F&border_radius=12&no_labels=true&plain=true&origin=ALA&promo_id=7879&campaign_id=100" charset="utf-8"></script>
            @else
                <x-external.disabled service="Виджет авиабилетов"/>
            @endexternal
        </div><!--.s_result_relative3-->
    </div><!--.s_result_-->
</div><!--.-->
