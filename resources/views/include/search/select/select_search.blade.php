<div class="select_search_tours__wrap @if(route_name() != 'home') pad_t1 @endif">
    <div class="select_search_tours">
    <a href="{{asset(route('search_new_tours'))}}" class="{{ active_linkMenu(asset(route('search_new_tours'))) }}
     {{ active_linkMenu(asset(route('home'))) }} sst_ sst_1" data-res="s_result_relative1"><span>{{__('Поиск туров')}}</span></a>
    <a href="{{asset(route('search_hotels'))}}"  class="{{ active_linkMenu(asset(route('search_hotels'))) }} sst_ sst_2" data-res="s_result_relative2"><span>{{__('Поиск отелей')}}</span></a>
</div>
</div>

