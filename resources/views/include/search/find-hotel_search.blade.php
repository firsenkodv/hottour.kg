<div class="hotel_search  z-index-23">
    <form action="{{ route('search_new_tours') }}" id="formsearch" method="get" name="formsearch">
        @csrf
        <div class="s_block flex page_search__top">

            @include('include.search.top_form.s_hotels')

            @include('include.search.top_form.s_sity')

            @include('include.search.top_form.s_date')

            @include('include.search.top_form.s_q_night')

            @include('include.search.top_form.s_people')

            @include('include.search.buttons.bottom_hotels_button')

        </div>
    </form>
</div>

@include('include.search.js.find-hotel_js')

@section('jquery-ui')
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
@endsection

