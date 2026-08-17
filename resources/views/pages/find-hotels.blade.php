@extends('layouts.layout')
@section('content')
    <main class="page_search__wrapper">
        @include('include.search.select.select_search_type')

        @include('include.search.select.select_search')
        @include('include.search.find-hotel_search')

        <div class="s_page">
            <div class="s_progress display_none"><span class="progress"></span></div>
            <br>
            <div id="search_loader"><span class="loader2"></span></div>
        </div>
        <div class="s_page s_page__hotel s_page__tours" id="resultHotel"></div>
    </main>
@endsection


