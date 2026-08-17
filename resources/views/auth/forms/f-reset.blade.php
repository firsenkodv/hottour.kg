<div class="auth  block">
        <div class="formRegister">
            <div class="F_h1 pad_b17"><span>{{ __('Восстановление пароля') }}</span></div>
            <div class="F_h2 pad_b23">{{ __('Придумайте новый пароль') }}</div>
            <x-forms.auth-form
                title=""
                subtitle=""
                action="{{ route('password.handle') }}"
                method="POST"
            >
                <input type="hidden" value="{{ $token }}" name="token"/>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="email"
                        id="resetEmail"
                        name="email"
                        placeholder="E-mail"
                        value="{{(request()->get('email'))?  : ''  }}"
                        class="input email"
                        required="true"
                        :isError="$errors->has('email')"
                    />
                    <x-forms.error class="error_email"/>

                </div>


                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="password"
                        id="resetPassword"
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
                        id="resetPassword_confirmation"
                        name="password_confirmation"
                        placeholder="Повторите пароль"
                        required="true"
                        class="input email"
                        :isError="$errors->has('email')"
                    />

                    <x-forms.error class="error_email"/>

                </div>

                {{--       <x-forms.cabinet.radio />--}}

                <x-slot:buttons>
                    <div class="slotButtons pad_t24">
                        <div class="text_input">
                            <x-forms.primary-button>
                                {{ __('Обновить пароль') }}
                            </x-forms.primary-button>
                        </div>

                    </div>
                </x-slot:buttons>
            </x-forms.auth-form>
        </div>
</div>
