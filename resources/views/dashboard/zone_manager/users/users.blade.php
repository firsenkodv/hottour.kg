<div class="dashboardBox">

    <div class="dashboardBox__title">
        <div class="a_user__row a_user">

            <div class="a_user__name">
                {{ __('ФИО, возраст') }}
            </div>
            <div class="a_user__email">
                {{ __('E-mail, телефон') }}
            </div>

            <div class="a_user__personal_nolink">
                {{ __('Тип профиля') }}
            </div>
        </div>

    </div>

    @include('dashboard.zone_manager.forms.search_users')

    <div class="dashboardBox__a_users a_users pad_b26">
        @if(count($users))
            @foreach($users as $user)
                <div class="a_user__row a_user @if(!$user->published) published_0 @endif  @if(role($user->id) == 'manager' or role($user->id) == 'senior') background_green @endif @if(role($user->id) == 'admin') background_biruza @endif">

                    <div class="a_user__name">
                        <div class="a_user__nameFio">
                            <div class="a_user__left">
                                {{ ($user->name)?:__('Неуказано') }}
                                @if(count($user->users))
                                    <span class="color_grey color_grey_12" title="{{__('Закрепленные пользователи')}}">{{ count($user->users) }}</span>
                                @endif
                            </div>
                            <div class="a_user__right LC_icons">
                                @if($user->manager_reserve)<span class="LC_manager" title="{{__('Менеджер по умолчанию')}}">{{ __('M') }}</span>@endif
                                @if(role($user->id) == 'senior')<span class="LC_senior_manager"  title="{{__('РОП')}}">{{ __('Р') }}</span>@endif
                                @if($user->cashback)<span class="LC_senior_cash"  title="{{__('Кешбэк')}}">{{ price($user->cashback) }}</span>@endif
                                @if($user->ball)<span class="LC_senior_ball"  title="{{__('Баллы')}}">{{ price($user->ball) }}</span>@endif
                            </div>
                        </div>
                        <div class="a_user__nameBirthdate color_grey color_grey_12">{{ ($user->birthdate)? birthdate($user->birthdate) :'' }}</div>

                    </div>
                    <div class="a_user__email">
                        <div class="a_user__nameFio">{{ $user->email }}</div>
                        <div class="a_user__nameBirthdate color_grey color_grey_12">
                            <a href="tel:{{ $user->phone }}">{{ format_phone($user->phone) }}</a>
                        </div>
                    </div>

                    <a href="{{ asset(route('page.manager_UsersPageUser', ['id' => $user->id]) ) }}" class="a_user__personal">
                        {{ role($user->id) }}
                        <span><img src="{{ asset('/images/arrow/next.svg') }}" alt="next" /></span>
                    </a>

                    @if(role($user->id) == "user")
                    @include('dashboard.forms.delete_user', ['user' => $user])
                    @endif
                </div>
            @endforeach
        @else
            <h3 class="F_h1 pad_t1_important noresult">{{ __('Нет результатов') }}</h3>
        @endif
    </div>

</div>
{{ $users->withQueryString()->links('pagination::default') }}
