@extends('html.email.layouts.layout_default_mail')
@section('title', 'Договор подписан on-line')
@section('description')
    {{ __('Договор №') }} <span style="color: #282828">{{$data['contract']}}</span> {{ __('подписан') }}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828; line-height: 1.4em">
        Извещаем Вас что Вами был подписан договор.<br>
        Просим Вас выполнить надлежащим образом условия договора с Вашей стороны.<br>
        Благодарим Вас за доверие оказанное ТОО "HOT TOUR".</p>

    <p style="word-wrap: break-word; color: #282828">
        <b>{{__('№ договора:')}}</b> {{$data['contract']}}<br>
        <b>{{__('ФИО:')}}</b> {{$data['name']}}<br>
        <b>{{__('Email:')}}</b> {{$data['email']}}<br>
        <b>{{__('Телефон:')}}</b> {{$data['phone']}}<br>
        <b>{{__('Дата:')}}</b> {{$data['date']}}<br>
        <b>{{__('Подпись:')}}</b> {{__('Документ подписан электронной подписью')}}</p>
    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>

@endsection
