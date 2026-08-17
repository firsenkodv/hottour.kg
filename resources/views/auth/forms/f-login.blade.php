<div class="auth  block">
        <div class="formRegister">
            <div class="F_h1 pad_b4"><span>{{ __('Войти в личный кабинет') }}</span></div>
            <div class="F_h2 pad_b23">или <a href="{{route('register')}}">создайте новый</a></div>
            <x-forms.auth-form
                title=""
                subtitle=""
                action="{{ route('login.handle.phone_email') }}"
                method="POST"
            >
                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="enterPhoneEmail"
                        name="phone_email"
                        placeholder="Номер телефона или email"
                        required="true"
                        class="input phone_email"
                        value="{{ old('phone_email') }}"
                        :isError="$errors->has('phone_email')"
                    />
                    <x-forms.error class="error_phone_email"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="password"
                        id="enterPassword"
                        name="password"
                        placeholder="Пароль"
                        required="true"
                        class="input password"
                        :isError="$errors->has('password')"
                    />

                    <x-forms.error class="error_password"/>

                </div>

                <x-slot:buttons>
                    <div class="slotButtons pad_t15">
                        <div class="text_input">
                            <x-forms.primary-button>
                                {{ __('Войти') }}
                            </x-forms.primary-button>
                        </div>
                        <div class="text_input pad_t14">
                            <div class="__enter"><a
                                    href="{{route('login.email')}}">{{ __('Войти через email') }}</a>
                            </div>
                        </div>
                        <div class="text_input pad_t4_important">
                            <div class="__enter"><a
                                    href="{{route('forgot')}}">{{ __('Я забыл пароль') }}</a>
                            </div>
                        </div>
                    </div>
                </x-slot:buttons>
            </x-forms.auth-form>
        </div>
</div>
