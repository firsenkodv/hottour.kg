<div class="shower_search shower_search__js">
    <div class="block relative"><div class="cancel-circle cancel-circle__js"></div></div>
    @include('include.search.index_search_old')
</div>
<header>
    <div class="background_000000">
        <div class="block">
            <div class="flex header_top menu_social">
                <div class="menu_social__menu">
                    @include('include.menu.menu')
                </div>
                <div class="menu_social__social">
                    @include('include.icons.top_social')
                    @include('include.translate.translate')
                </div>

            </div><!--.header_top-->
        </div>
    </div><!--.background_000000-->
     <div class="fix  {{ $route }}">
        <div class="background_282828 {{ $route }}">
    <div class="block">
        <div class="hb header_bottom flex">

            <div class="hb__left">
                <div class="hb__logo">
                    <x-logo.logo
                    width="260"
                    height="48"
                    />
                </div>
                <div class="hb__social">
                    @if(route_name() == 'home' or route_name() == 'search_tours' or route_name() == 'search_new_tours')

                        @include('include.icons.top_social_big')

                    @else
                        <div class="imgtemp__search imgtemp__search_page imgtemp__search__js">
                            <div class="sbtn_ ic_destination">
                                <span class="serchbtn_input">{{ __('Поиск туров и курортов') }}</span>
                                <span class="serchbtn_svg"></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hb__right flex">
                <div class="hb__col hb__one">
                    <div class="top_order_call">
                        @include('include.ordercall.top_order_call')
                    </div>

                    <div class="top_select_sity">
                        @include('include.selectsity.select_sity')
                    </div>
                </div>
                <div class="hb__col hb__two">
                    @include('include.enter.enter')
                </div>

            </div>

        </div><!--.header_bottom-->
    </div>
    </div><!--.background_282828-->
     </div><!--.fix  {{ $route }}-->
</header>
