<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('update.manager') }}"
        method="POST"
    >

        <div class="c__flex">
            <div class="c__flex_50 c__flex_50_left">

                <div class="text_input">
                     <div class="text_input__label">{{__('Изменить имя')}}</div>
                </div>
               <div class="text_input">
                     <div class="text_input__label">{{__('Изменить телефон')}}</div>
                </div>
               <div class="text_input">
                     <div class="text_input__label">{{__('Изменить email')}}</div>
                </div>
               <div class="text_input">
                     <div class="text_input__label">{{__('WhatsApp')}}</div>
                </div>

               <div class="text_input">
                     <div class="text_input__label">{{__('Telegram')}}</div>
                </div>


            </div><!--.c__flex_50_left-->
            <div class="c__flex_50 c__flex_50_right">

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerTitle"
                        name="title"
                        placeholder="Имя"
                        value="{{  (isset($item->connection->title))?$item->connection->title:old('title') }}"
                        class="input title"
                        :isError="$errors->has('title')"
                    />
                    <x-forms.error class="error_title"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerPhone"
                        name="phone"
                        placeholder="Телефон"
                        value="{{  (isset($item->connection->phone))?$item->connection->phone:old('phone') }}"
                        class="input phone"
                        :isError="$errors->has('phone')"
                    />
                    <x-forms.error class="error_phone"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerEmail"
                        name="email"
                        placeholder="E-mail"
                        value="{{  (isset($item->connection->email))?$item->connection->email:old('email') }}"
                        class="input email"
                        :isError="$errors->has('email')"
                    />
                    <x-forms.error class="error_email"/>

                </div>


                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerWhatsapp"
                        name="whatsapp"
                        placeholder="Whatsapp"
                        value="{{  (isset($item->connection->whatsapp))?$item->connection->whatsapp:old('whatsapp') }}"
                        class="input whatsapp"
                        :isError="$errors->has('whatsapp')"
                    />
                    <x-forms.error class="error_whatsapp"/>

                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="registerTelegram"
                        name="telegram"
                        placeholder="Telegram"
                        value="{{  (isset($item->connection->telegram))?$item->connection->telegram:old('telegram') }}"
                        class="input telegram"
                        :isError="$errors->has('telegram')"
                    />
                    <x-forms.error class="error_telegram"/>

                </div>


            </div><!--.c__flex_50_right-->
        </div><!--.c__flex-->


        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $item->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Изменить внешние данные') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.form>

</div>



