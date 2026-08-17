<div class="s_s">

    <div class="s_s_change_tabs">
        <div class="s_s_change_tab __tab__js active" data-change="__old__js">{{ __('старый поиск') }}</div>
        <div class="s_s_change_tab __tab__js" data-change="__new__js">{{ __('новый поиск') }}</div>
    </div>

    <div class="s_s_change">
        <div class="s_change __new__js">
            @include('include.search.select.select_search')
            @include('include.search.index_search')
        </div>
        <div class="active s_change __old__js">
            @include('include.search.index_search_old')
        </div>
    </div>

</div><!--.s_s-->

