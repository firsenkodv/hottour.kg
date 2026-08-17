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

    <div class="dashboardBox__a_users a_users pad_b26">

        @foreach($managers as $manager)

            <div class="a_user__row a_user @if(!$manager->published) published_0 @endif  @if(role($manager->id) == 'manager' or role($manager->id) == 'senior') background_green @endif @if(role($manager->id) == 'admin') background_biruza @endif">
                <div class="a_user__name">
                    <div class="a_user__nameFio">
                        <div class="a_user__left">


                            {{ ($manager->name)?:__('Неуказано') }}
                            @if(count($manager->users))
                                <span class="color_grey color_grey_12" title="{{__('Закрепленные пользователи')}}">{{ count($manager->users) }}</span>
                            @endif
                        </div>
                        <div class="a_user__right LC_icons">
                            @if($manager->manager_reserve)<span class="LC_manager" title="{{__('Менеджер по умолчанию')}}">{{ __('M') }}</span>@endif
                            @if(role($manager->id) == 'senior')<span class="LC_senior_manager"  title="{{__('РОП')}}">{{ __('Р') }}</span>@endif
                            @if($manager->cashback)<span class="LC_senior_cash"  title="{{__('Кешбэк')}}">{{ price($manager->cashback) }}</span>@endif
                            @if($manager->ball)<span class="LC_senior_ball"  title="{{__('Баллы')}}">{{ price($manager->ball) }}</span>@endif
                        </div>
                    </div>
                    <div class="a_user__nameBirthdate color_grey color_grey_12">{{ ($manager->birthdate)? birthdate($manager->birthdate) :'' }}</div>

                </div>
                <div class="a_user__email">
                    <div class="a_user__nameFio">{{ $manager->email }}</div>
                    <div class="a_user__nameBirthdate color_grey color_grey_12">
                        <a href="tel:{{ $manager->phone }}">{{ format_phone($manager->phone) }}</a>
                    </div>
                </div>

                <a href="{{route('page.senior', ['id' => $manager->id])}}" class="a_user__personal">
                    {{ role($manager->id) }}
                    <span><img src="/images/arrow/next.svg" alt="next"></span>
                </a>

            @include('dashboard.forms.delete_senior', ['user' => $manager])

            </div>
        @endforeach

    </div>

</div>
{{ $managers->withQueryString()->links('pagination::default') }}

