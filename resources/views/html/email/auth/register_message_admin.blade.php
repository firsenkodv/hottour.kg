@extends('html.email.layouts.layout_default_mail')
@section('title', 'Создан аккаунт')
@section('description')
    {{__('Пользователь') }} {{ $user->name }} {{  __('создал аккаунт.')}}
@endsection
@section('content')

    <p style="word-wrap: break-word;"><b>{{__('Логин')}}</b> - <span style="color: #282828">{{ $user['email']  }}</span><br>
        <b>{{__('Пароль')}}</b> - <span style="color: #282828">{{ $user['password']  }}</span><br>


    <p style="word-wrap: break-word;">{{__('Новый пользователь получил уведомление о регистрации')}}</p>
@endsection

