<div class="formCabinet">
    <x-forms.auth-form
        title=""
        subtitle=""
        action="{{ route('setting.password.handel') }}"
        method="POST"
        enctype=""
    >

        <div class="c__flex">
            <div class="c__flex_50 c__flex_50_left">

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="password"
                        id="registerPassword"
                        name="password"
                        placeholder="Пароль"
                        required="true"
                        class="input password"
                        :isError="$errors->has('password')"
                    />
                    <x-forms.error class="error_password"/>
                </div>




                </div><!--.c__flex_50_left-->
            <div class="c__flex_50 c__flex_50_right">

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="password"
                        id="registerPassword_confirmation"
                        name="password_confirmation"
                        placeholder="Повторите пароль"
                        required="true"
                        class="input password"
                        :isError="$errors->has('password')"
                    />
                    <x-forms.error class="error_password"/>

                </div>



            </div><!--.c__flex_50_right-->
        </div><!--.c__flex-->


        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $user->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Изменить пароль') }}
                </x-forms.primary-button>
            </div>

        </div>

    </x-forms.auth-form>

</div>



