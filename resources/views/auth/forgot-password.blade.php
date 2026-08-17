@extends('layouts.layout')
@section('title', __('Забыли пароль'))
@section('description', __('Забыли пароль'))
@section('keywords', __('Забыли пароль'))
    @section('content')

        <div class="pageRegister pages_auth">

            <div class="kab_flex axeld_flex axeld100">
                <div class="kab_left color_fff">
                    @include('auth.authdesc.desc')
                </div><!--.kab_left-->
                <div class="kab_right">

                    @include('auth.forms.f-forgot')


                </div><!--.kab_right-->
            </div>

        </div>

    @endsection
