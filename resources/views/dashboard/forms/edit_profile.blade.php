<div class="formCabinet">
    <x-forms.auth-form
        title=""
        subtitle=""
        action="{{ route('setting.handel') }}"
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
                            value="{{ (old('name'))?:$user->name }}"
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
                            value="{{ (old('phone'))?:$user->phone }}"
                            :isError="$errors->has('phone')"
                        />
                        <x-forms.error class="error_phone"/>

                    </div>


                </div><!--.c__flex_50_left-->
                <div class="c__flex_50 c__flex_50_right">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            readonly="readonly"
                            id="registerEmail"
                            name="email"
                            placeholder="E-mail"
                            required="true"
                            class="input email"
                            value="{{ (old('email'))?:$user->email }}"
                            :isError="$errors->has('email')"
                        />
                        <x-forms.error class="error_email"/>

                    </div>

                    <div class="text_input pad_t8_important">

                        <div class="birthdate_wrap">
                        @if($user->birthdate)
                            <div class="birthdate">
                                {{ __('Дата рождения') }}

                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="birthdate"
                                    :value="$user->birthdate"
                                    :result-text="rusdate3($user->birthdate)"
                                />
                            </div>
                        @else
                            <div class="birthdate">

                                <span>{{ __('Дата рождения') }}</span>

                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="birthdate"
                                    value="1970-01-01"
                                    :result-text="__('Добавить')"
                                />
                            </div>
                        @endif
                        </div>
                    </div>

                </div><!--.c__flex_50_right-->
            </div><!--.c__flex-->

            <div class="c__flex">
                <div class="c__flex_50 c__flex_50_left">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerInn"
                            name="inn"
                            placeholder="ИНН"
                            value="{{ (old('inn'))?:$user->inn }}"
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
                            value="{{ (old('passport'))?:$user->passport }}"
                            class="input passport"
                            :isError="$errors->has('passport')"
                        />
                        <x-forms.error class="error_passport"/>

                    </div>

                </div><!--.c__flex_50_left-->
                <div class="c__flex_50 c__flex_50_right">

                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="registerPassportIssuedAt"
                            name="passport_issued_at"
                            placeholder="Выдан"
                            value="{{ (old('passport_issued_at'))?:$user->passport_issued_at }}"
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
                            value="{{ (old('passport_issued_by'))?:$user->passport_issued_by }}"
                            class="input passport_issued_by"
                            :isError="$errors->has('passport_issued_by')"
                        />
                        <x-forms.error class="error_passport_issued_by"/>

                    </div>

                </div><!--.c__flex_50_right-->
            </div><!--.c__flex-->

        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $user->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Изменить профиль') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.auth-form>

    </div>


