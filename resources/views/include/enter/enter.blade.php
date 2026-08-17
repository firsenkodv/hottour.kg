<div class="enter_to_website">

    @auth

<div class="enter_to_website__a">
        <a href="{{ route('setting') }}" title="Вход  в личный кабинет"  class="">

            <div class="site_avatar" style="background-image: url('@if(isset(auth()->user()->avatar)) {{ Storage::disk('user')->url(auth()->user()->avatar) }} @else {{ asset('images/inline/dashboard-left-bar-avatar-1.svg') }} @endif ');  width: 36px; height: 36px"></div>



        </a>
        <x-forms.auth-form_mob
            title=""
            subtitle=""
            action="{{ route('logout') }}"
            method="POST"
        >
            <button type="submit" class="enter_to_website__a2"> <span title="Выход из личного кабинета" class="sp__kab">{{__('Выход')}}</span> </button>
        </x-forms.auth-form_mob>
</div>


    @endauth

    @guest
            <a href="/login" class="enter_to_website__a">
                <div class="site_avatar" style="background-image: url('{{ asset('images/inline/dashboard-left-bar-avatar-1.svg') }}');  width: 36px; height: 36px"></div>
                <span class="sp__kab" title="Вход  в личный кабинет">{{__('Вход')}}</span>
            </a>
    @endguest



</div>
