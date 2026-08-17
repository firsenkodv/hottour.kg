@extends('html.email.layouts.layout_default_mail')
@section('title', 'Заявка с сайта. Тур из поиска')
@section('description')
    {!!  'Пользователь отправил заявку с сайта<br> на подобранный им тур.' !!}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828"><b>{{__('Имя:')}}</b> {{$data['name']}}<br>
        <b>{{__('Email:')}}</b> {{$data['email']}}<br>
        <b>{{__('Телефон:')}}</b> {{$data['phone']}}</p>
    <hr>
    <p style="word-wrap: break-word; color: #282828">{{__('Страна:')}}<b style="font-size: 20px">{!! $data['country'] !!}</b></p>
    <p style="word-wrap: break-word; color: #282828; line-height: 1.3em">
        Отель: <b style="font-size: 20px">{!!$data['hotel']!!}</b><br>
        <span style="color: #667085">{!!$data['mealrussian']!!}</span></p>
    <p style="word-wrap: break-word; color: #282828">
        {!!$data['sity']!!}<br>
        {!!$data['from']!!}<br>
        {!!$data['to']!!}<br>
        {!!$data['nights']!!}<br>
        {!!$data['adults']!!}<br>
        {!!$data['childs']!!}<br>
        {!!$data['room']!!}<br>
        {!!$data['tourname']!!}<br>
        {!!$data['price']!!}
    </p>
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>
    <p style="word-wrap: break-word;">{{__('Страница перехода')}} -
        <span style=" color: #29abe2"> {{$data['url']}} </span></p>
@endsection
