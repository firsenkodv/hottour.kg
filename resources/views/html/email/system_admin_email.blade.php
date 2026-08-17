@extends('html.email.layouts.layout_default_mail')
@section('title', 'Системное сообщение')
@section('description')
    {!!  'Сообщение для технического специалиста' !!}<br>
@endsection
@section('content')
    <p style="word-wrap: break-word; color: #282828"><b>{{__('file_commands:')}}</b>{{$data['file_commands']}}<br>
        <b>{{__('commands:')}}</b>{{$data['commands']}}</p>
    <hr>
    @if($data['body'])
    <p>
        @foreach($data['body'] as $b)
            {{ $b }} <br>

        @endforeach
    </p>
    @endif
    <p><a href="{{ env('APP_URL') . '/login' }}" class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Войти на сайт') }}</a></p>

@endsection
