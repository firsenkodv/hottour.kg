@extends('html.email.layouts.layout_default_mail')
@section('title', 'Заявка с сайта.')
@section('description')
    {{__('Пользователь отправил заявку с сайта.')}}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828"><b>{{__('Имя:')}}</b> {{$data['name']}}<br>
        <b>{{__('Email:')}}</b> {{$data['email']}}<br>
        <b>{{__('Телефон:')}}</b> {{$data['phone']}}</p>
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>
    <p style="word-wrap: break-word;">{{__('Страница перехода')}} -
        <span style=" color: #29abe2"> {{$data['url']}} </span></p>
@endsection
