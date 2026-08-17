<div class="auth  block">
    <div class="formRegister">
        <div class="F_h1 pad_b17"><span>{{ __('Регистрация') }}</span></div>
        <x-forms.auth-form
            title=""
            subtitle=""
            action="{{ route('register.handle') }}"
            method="POST"
        >
            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="text"
                    id="registerName"
                    name="name"
                    placeholder="Имя"
                    value="{{ old('name') }}"
                    class="input name"
                    required="true"
                    :isError="$errors->has('name')"
                />
                <x-forms.error class="error_name"/>

            </div>

            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="text"
                    id="registerEmail"
                    name="email"
                    placeholder="E-mail"
                    required="true"
                    class="input email"
                    value="{{ old('email') }}"
                    :isError="$errors->has('email')"
                />
                <x-forms.error class="error_email"/>

            </div>
            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="text"
                    id="registerPhone"
                    name="phone"
                    placeholder="Номер телефона"
                    required="true"
                    class="input phone"
                    value="{{ old('phone') }}"
                    :isError="$errors->has('phone')"
                />
                <x-forms.error class="error_phone"/>

            </div>

            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="password"
                    id="registerPassword"
                    name="password"
                    placeholder="Пароль"
                    required="true"
                    class="input email"
                    :isError="$errors->has('email')"
                />

                <x-forms.error class="error_password"/>

            </div>

            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="password"
                    id="registerPassword_confirmation"
                    name="password_confirmation"
                    placeholder="Повторите пароль"
                    required="true"
                    class="input email"
                    :isError="$errors->has('email')"
                />

                <x-forms.error class="error_email"/>

            </div>

            <div class="text_input">
                <x-forms.text-input_fromLabel
                    type="text"
                    id="registerPromo"
                    name="promo"
                    placeholder="Промокод"
                    value="{{ old('promo') }}"
                    class="input promo"
                    :isError="$errors->has('promo')"
                />
                <x-forms.error class="error_promo"/>

            </div>

            @if(isset($item))
                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerInn"
                        name="inn"
                        placeholder="ИНН"
                        value="{{ old('inn') }}"
                        class="input inn"
                        :isError="$errors->has('inn')"
                    />
                    <x-forms.error class="error_inn"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerPassport"
                        name="passport"
                        placeholder="Паспорт"
                        value="{{ old('passport') }}"
                        class="input passport"
                        :isError="$errors->has('passport')"
                    />
                    <x-forms.error class="error_passport"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerPassportIssuedAt"
                        name="passport_issued_at"
                        placeholder="Выдан"
                        value="{{ old('passport_issued_at') }}"
                        class="input passport_issued_at"
                        :isError="$errors->has('passport_issued_at')"
                    />
                    <x-forms.error class="error_passport_issued_at"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerPassportIssuedBy"
                        name="passport_issued_by"
                        placeholder="Кем выдан"
                        value="{{ old('passport_issued_by') }}"
                        class="input passport_issued_by"
                        :isError="$errors->has('passport_issued_by')"
                    />
                    <x-forms.error class="error_passport_issued_by"/>

                </div>
            @endif

            @if(isset($item))
                @if(role($item->id) == 'manager' or role($item->id) == 'senior')
                    {{--это для закрепления за регистрируемым менеджером--}}
                    <input type="hidden" name="id" value="{{$item->id}}">
                @endif
                {{--это для переадресации на уровень админа-менеджера обратно в ЛК--}}
                <input type="hidden" name="redirect_for_route_page_users" value="1">
                @if(isset($add))
                    @if($add == 'manager')
                        {{--создаем не простого пользователя а мененджера--}}
                        <input type="hidden" name="{{$add}}" value="{{$add}}">
                    @endif
                @endif
                    @if(isset($senior))
                    @if($senior == 'senior')
                        {{--создаем не простого пользователя а мененджера и закрепляеми его за РОП ом--}}
                        <input type="hidden" name="{{$senior}}" value="{{$item->id}}">
                    @endif
                @endif
            @endif
            {{--       <x-forms.cabinet.radio />--}}

            <x-slot:buttons>
                <div class="slotButtons pad_t24">
                    <div class="text_input">
                        <x-forms.primary-button>
                            {{ __('Создать аккаунт') }}
                        </x-forms.primary-button>
                    </div>

                    <div class="text_input">
                        <div class="__enter"><span>{{ __('У вас уже есть личный кабинет?') }}</span> <a
                                href="/login">{{ __('Войти') }}</a>
                        </div>
                    </div>

                </div>
            </x-slot:buttons>
        </x-forms.auth-form>
    </div>
</div>
