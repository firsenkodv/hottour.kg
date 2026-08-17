@extends('layouts.layout')
@section('title', __('Вход по email') )
@section('description', __('Вход по email') )
@section('keywords', __('Вход по email') )
@section('content')

    <div class="pageRegister pages_auth">

        <div class="kab_flex axeld_flex axeld100">
            <div class="kab_left color_fff">
                @include('auth.authdesc.desc')
            </div><!--.kab_left-->
            <div class="kab_right">

                @include('auth.forms.f-login-email')


            </div><!--.kab_right-->
        </div>

    </div>

@endsection
