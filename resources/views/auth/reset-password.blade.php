@extends('layouts.layout')
@section('title', __('Восстановление пароля'))
@section('description', __('Восстановление пароля'))
@section('keywords', __('Восстановление пароля'))
@section('content')

    <div class="pageRegister pages_auth">

        <div class="kab_flex axeld_flex axeld100">
            <div class="kab_left color_fff">
                @include('auth.authdesc.desc')
            </div><!--.kab_left-->
            <div class="kab_right">

                @include('auth.forms.f-reset')


            </div><!--.kab_right-->
        </div>

    </div>
@endsection
