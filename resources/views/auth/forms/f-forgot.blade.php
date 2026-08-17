<div class="auth  block">
        <div class="formRegister">
            <div class="F_h1 pad_b4"><span>{{ __('Забыли пароль') }}</span></div>
            <div class="F_h2 pad_b23">{{ __('Введите почту с которым зарегистрировались на сайте') }}</div>
            <x-forms.auth-form
                title=""
                subtitle=""
                action="{{ route('forgot.handel') }}"
                method="POST"
            >
                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="email"
                        id="forgotEmail"
                        name="email"
                        placeholder="E-mail"
                        required="true"
                        class="input email"
                        value="{{ old('email') }}"
                        :isError="$errors->has('email')"
                    />
                    <x-forms.error class="error_email"/>

                </div>


                <x-slot:buttons>
                    <div class="slotButtons pad_t15">
                        <div class="text_input">
                            <x-forms.primary-button>
                                {{ __('Отправить') }}
                            </x-forms.primary-button>
                        </div>

                        <div class="text_input pad_t4_important">
                            <div class="__enter"><a
                                    href="{{route('login')}}">{{ __('Я забыл вспомнил пароль') }}</a>
                            </div>
                        </div>
                    </div>
                </x-slot:buttons>
            </x-forms.auth-form>
        </div>
</div>
