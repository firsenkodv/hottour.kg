@extends('html.email.layouts.layout_default_mail')
@section('title', 'Создан аккаунт')
@section('description', 'Данные для входа.')
@section('content')

    <p style="word-wrap: break-word;"><b>{{__('Логин')}}</b> - <span style="color: #282828">{{ $user['email']  }}</span><br>
        <b>{{__('Пароль')}}</b> - <span style="color: #282828">{{ $user['password']  }}</span><br>

    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>
    <p style="word-wrap: break-word;">{{__('Адрес для входа в аккаунт')}} -
        <span style=" color: #29abe2"> {{ env('APP_URL') . '/login' }} </span></p>
@endsection

