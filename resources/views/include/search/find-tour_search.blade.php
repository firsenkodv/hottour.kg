
<div class="page_search page_search_mar-b42 z-index-23">
    <form action="{{ route('search_new_tours') }}" id="formsearch" method="get" name="formsearch" data-token="{{ csrf_token() }}">
        @csrf
        <div class="s_block flex page_search__top">

            @include('include.search.top_form.s_sity')

            @include('include.search.top_form.s_dep')

            @include('include.search.top_form.s_date')

            @include('include.search.top_form.s_q_night')

            @include('include.search.top_form.s_people')

        </div>

        <div class="s_block flex page_search__bottom">

            <div class="flex s_bottomleft">

                @include('include.search.bottom_form.s_regions')

                @include('include.search.bottom_form.s_hotels')

            </div>

            <div class="s_bottomright">

                <div class="s_bottomright__flex">

                    <div class="s_bottomright__top s_sb">

                        @include('include.search.bottom_form.s_meals')

                        @include('include.search.bottom_form.s_stars')

                    </div>

                    @include('include.search.bottom_form.s_range')

                    @include('include.search.buttons.bottom_button')

                </div>

            </div>

        </div>

        @include('include.search.modal.hotelpamams')

    </form>
    @include('include.search.js.find-tour_js')
</div>


