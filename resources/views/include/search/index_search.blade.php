<div class="index_search  z-index-23">
    <form action="{{ route('search_new_tours') }}" id="formsearch" method="get" name="formsearch">
        @csrf
        <div class="s_block flex page_search__top">

            @include('include.search.top_form.s_sity')

            @include('include.search.top_form.s_dep')

            @include('include.search.top_form.s_date')

            @include('include.search.top_form.s_q_night')

            @include('include.search.top_form.s_people')

            @include('include.search.buttons.top_button')

        </div>
    </form>
</div>

@include('include.search.js.index_js')

