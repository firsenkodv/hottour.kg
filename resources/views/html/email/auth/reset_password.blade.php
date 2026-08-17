@extends('html.email.layouts.layout_default_mail')
@section('title', 'Здравствуйте')
@section('description', 'Вы получили это письмо, потому что мы получили запрос на сброс пароля для Вашей учётной записи.')
@section('content')
    <p><a href="{{ env('APP_URL') . '/reset-password/'.$data['token'].'?email='.$data['email']}}"
          class="btn btn-primary" style="background: #29abe2;border-radius: 5px;color: #ffffff;display: inline-block;padding: 10px 15px 10px 15px;text-decoration: none;">{{ __('Сбросить пароль') }}</a></p>
    <p style="word-wrap: break-word;">{{ __('Или скопируйте и вставьте приведенный ниже URL-адрес в свой браузер: ') }}
        <br><span
            style=" color: #29abe2">{{ env('APP_URL') . '/reset-password/'.$data['token'].'?email='.$data['email']}}</span>
    </p>
@endsection
