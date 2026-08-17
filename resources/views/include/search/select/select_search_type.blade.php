<div class="s_s_change_tabs__wrap">
    <div class="s_s_change_tabs">
        <div class="s_s_change_tab @if(route_name() == 'search_tours' ) active @endif"><a href="{{ route('search_tours') }}">{{ __('старый поиск') }}</a></div>
        <div class="s_s_change_tab @if(route_name() == 'search_new_tours' ) active @endif"><a href="{{ route('search_new_tours') }}">{{ __('новый поиск') }}</a></div>
</div>
</div>
