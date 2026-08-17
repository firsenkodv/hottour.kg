@extends('html.email.layouts.layout_default_mail')
@section('title', 'Тестовое Системное сообщение')
@section('description')
    {!!  'Тестовое Сообщение для технического специалиста' !!}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828"><b>Письмо успешно отправлено методом SMTP</b></p>
    @if($data)
        {{ $data }}
    @endif
    <hr>
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>

@endsection

