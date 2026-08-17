@extends('layouts.layout')
@section('title', 'Кабинет')
@section('content')
    @yield('cabinet')
@endsection

@section('tourvisor')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}"/>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/jquery.daterangepicker.min.js') }}"></script>
@endsection

