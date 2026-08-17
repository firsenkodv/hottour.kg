<div class="hh__3_right top_sity_js" data-token="{{ csrf_token() }}">
    <div class="hhh_img">
        <span><img  src="{{ asset('images/inline/include-selectsity-select-sity-1.svg') }}" width="20" height="20"  alt="Телефон"></span>
    </div>
    <div class="hhh_adr">
        <span class="h_s_sity"><span class="h_s_sity_js">
                @if(is_null($session_sity))
                    {{config('selects.data_sity.almaty.text')}}
                @else
                    {{$session_sity}}
                @endif
            </span> телефон</span>
        <span class="h_s_phone">{!! (isset($setting['phone1']))? $setting['phone1'] : '' !!}</span>
    </div><!--.hhh_adr-->

</div><!--.hh__3_right-->

    <div class="tps_ul">
        <div class="tps_ul_absol top_sity_active_js" style="display: none;">


           @foreach( config('selects.data_sity') as $k=>$v)
                <div class="city__{{$k}}">
                    <div class="tps_ph_2 tps_sity_title tps_sity_title_js {{($v['text'] == $session_sity)?'active':''}}">{{$v['text']}}</div>
                </div><!--.ph__-->
           @endforeach

        </div><!--.tps_ul_absol-->
    </div><!--.tps_ul-->


