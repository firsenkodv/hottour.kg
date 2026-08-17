<div class="formCabinet">
    <x-forms.auth-form
        title=""
        subtitle=""
        action="{{ route('update.user') }}"
        method="POST"
        enctype="multipart/form-data"
    >

           <div class="c__flex">
                <div class="c__flex_50 c__flex_50_left">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerName"
                            name="name"
                            placeholder="Имя"
                            value="{{ (old('name'))?:$item->name }}"
                            class="input name"
                            required="true"
                            :isError="$errors->has('name')"
                        />
                        <x-forms.error class="error_name"/>

                    </div>

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerPhone"
                            name="phone"
                            placeholder="Номер телефона"
                            required="true"
                            class="input phone"
                            value="{{ (old('phone'))?:$item->phone }}"
                            :isError="$errors->has('phone')"
                        />
                        <x-forms.error class="error_phone"/>

                    </div>


                </div><!--.c__flex_50_left-->
                <div class="c__flex_50 c__flex_50_right">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerEmail"
                            name="email"
                            placeholder="E-mail"
                            required="true"
                            class="input email"
                            value="{{ (old('email'))?:$item->email }}"
                            :isError="$errors->has('email')"
                        />
                        <x-forms.error class="error_email"/>

                    </div>

                    <div class="text_input pad_t8_important">

                        <div class="birthdate_wrap">
                        @if($item->birthdate)

                            <div class="birthdate">
                                {{ __('Дата рождения') }}

                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="birthdate"
                                    :value="$item->birthdate"
                                    :result-text="rusdate3($item->birthdate)"
                                />
                            </div>
                        @else
                            <div class="birthdate">

                                <span>{{ __('Дата рождения') }}</span>

                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="birthdate"
                                    value=""
                                    :result-text="__('Добавить')"
                                />
                            </div>
                        @endif
                        </div>
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


