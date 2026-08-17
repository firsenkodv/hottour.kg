<div class="cabinet_radius12_fff">
    @include('dashboard.left_bar.avatar')
    <div class="c__title_subtitle">
        <h3 class="F_h1 left_bar__name" title="{{ $user->name }}">{{ $user->name }}</h3>
        <div class="F_h2 left_bar__email pad_t5"><span>{{ $user->email }}</span></div>
        @if($user->phone)
            <div class="left_bar__phone pad_t10"><span>{{ format_phone($user->phone) }}</span></div>
        @endif

        <div class="pd_b_new">
            <div class="pd_b_wrap">
                <div class="pd_bonus"><span>{{ ($user->bonus)?:0 }}</span> бонусов</div><!--.pd_bonus-->
            </div><!--.pd_b_wrap-->
            <div class="textnohtml_rel">
                <span class="underline">Как это работает?</span>
                <i>
                    {!! (isset($setting['bonus'])? $setting['bonus'] :'') !!}
                    <rp class="b__close">×</rp>
                </i>
            </div>
        </div>
        @if($user->ball)
            <div class="pd_b_new">
                <div class="pd_sale"><span class="pd_sale_name">Персональные баллы</span> <span
                        class="pd_sale_price">{{ $user->ball }}</span></div>
                <span class="textnohtml_rel">
            <span class="underline">Как это работает?</span>
<i>{!! (isset($setting['ball']))? $setting['ball'] :'' !!}<rp class="b__close">×</rp></i></span>
            </div>
        @endif
        @if($user->cashback)
            <div class="pd_b_new">
                <div class="pd_sale"><span class="pd_sale_name">Кешбэк</span> <span
                        class="pd_sale_price">{{ $user->cashback }} {{ config('currency.currency.KZT') }}</span></div>
                <span class="textnohtml_rel">
                        <span class="underline">Как это работает?</span>
                        <i>{!! (isset($setting['cashback']))? $setting['cashback'] :'' !!}
                <rp class="b__close">×</rp></i></span>
            </div>
        @endif


    </div>
</div>
@if($survey)
<div class="survey_user_wrapp__js">
<br>
<br>
<div class="cabinet_radius12_fff">
    @include('include.module.user_survey')
</div>
</div>
@endif
<br>
<br>
<div class="cabinet_radius12_fff">
    @include('dashboard.reserve.manager_reserve', ['item' => auth()->user()])
</div>
<br>
<br>
<div class="cabinet_radius12_fff">
    @include('dashboard.promo_code.promo_code')
</div>

