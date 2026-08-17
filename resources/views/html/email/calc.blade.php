@extends('html.email.layouts.layout_default_mail')
@section('title', 'Кредитный калькулятор.')
@section('description')
    {{__('Пользователь отправил заявку с кредитного калькулятора.')}}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828"><b>{{__('Телефон:')}}</b> {{$data['phone']}}<br>
        <b>{{__('Имя:')}}</b> {{$data['name']}}<br>
        <b>{{__('Email:')}}</b> {{$data['email']}}</p>
    <p style="word-wrap: break-word; color: #282828"><b>{{__('Банк')}}</b> {{ $data['bank'] }}<br>
        <b>{{__('Страна')}}</b> {{ $data['credit'] }}<br>
        <b>{{__('Кол-во месяцев')}}</b> {{ $data['month'] }}
    </p>
    <p style="word-wrap: break-word; color: #282828"><b>{{__('Ставка')}}</b> {{ $data['bet'] }}<br>
        <b>{{__('Срок')}}</b> {{ $data['term']  }}<br>
        <b>{{__('Ежемесячный платеж')}}</b> {{ $data['monthly_payment']  }}<br>
        <b>{{__('Переплата по кредиту')}}</b> {{ $data['overpayment']  }}<br>
        <b>{{__('Общая выплата')}}</b> {{ $data['total_payout']  }}</p>
    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>
    <p style="word-wrap: break-word;">{{__('Страница перехода')}} -
        <span style=" color: #29abe2"> {{$data['url']}}</span></p>
@endsection
