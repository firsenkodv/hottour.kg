<div class="formCabinet">
    <x-forms.auth-form
        title=""
        subtitle=""
        action="{{ route('update.user.ball') }}"
        method="POST"
    >

           <div class="c__flex">
                <div class="c__flex_50 c__flex_50_left">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerBall"
                            name="ball"
                            placeholder="Баллы"
                            value="{{ (old('ball'))?:$item->ball }}"
                            class="input ball"
                            :isError="$errors->has('ball')"
                        />
                        <x-forms.error class="error_ball"/>

                    </div>


                </div><!--.c__flex_50_left-->
                <div class="c__flex_50 c__flex_50_right">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerCashback"
                            name="cashback"
                            placeholder="Кешбэк"
                            class="input cashback"
                            value="{{ (old('cashback'))?:$item->cashback }}"
                            :isError="$errors->has('cashback')"
                        />
                        <x-forms.error class="error_cashback"/>

                    </div>


                </div><!--.c__flex_50_right-->
            </div><!--.c__flex-->


        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $item->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Изменить профиль') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.auth-form>

    </div>


