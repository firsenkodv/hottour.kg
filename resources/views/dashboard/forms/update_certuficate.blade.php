<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('update.certificate') }}"
        method="POST"
    >


        <div class="text_input">
            <x-forms.text-input_fromLabel
                type="text"
                id="Title"
                name="title"
                placeholder="Заголовок"
                value="{{ ($item->title)?:(old('title'))?:'' }}"
                class="input title"
                required="true"
                :isError="$errors->has('title')"
            />
            <x-forms.error class="error_title"/>

        </div>



        <div class="text_input">
            <x-forms.text-input_fromLabel
                type="text"
                id="Price"
                name="price"
                placeholder="Стоимость"
                class="input price"
                value="{{ ($item->price)?:(old('price'))?:'' }}"
                :isError="$errors->has('price')"
            />
            <x-forms.error class="error_price"/>

        </div>

        <div class="text_input">
            <x-forms.text-input_fromLabel
                type="text"
                id="Country_from"
                name="country_from"
                placeholder="Страна вылета"
                class="input country_from"
                value="{{ ($item->country_from)?:(old('country_from'))?:'' }}"
                :isError="$errors->has('country_from')"
            />
            <x-forms.error class="error_country_from"/>

        </div>
        <div class="text_input">
            <x-forms.text-input_fromLabel
                type="text"
                id="Country_to"
                name="country_to"
                placeholder="Страна прилета"
                class="input country_to"
                value="{{ ($item->country_to)?:(old('country_to'))?:'' }}"
                :isError="$errors->has('country_to')"
            />
            <x-forms.error class="error_country_to"/>

        </div>


        <div class="text_input pad_t8_important">

            <div class="birthdate_wrap">

                <div class="birthdate">

                    <span>{{ __('Дата') }}</span>

                    <x-forms.datepicker
                        mode="birthdate"
                        name="date"
                        :value="($item->date)?:date('Y-m-d')"
                        :result-text="rusdate3(($item->date)?:date('Y-m-d'))"
                    />
                </div>

            </div>
        </div>



        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $item->user_id  }}" name="user">
                <input type="hidden" value="{{ $user->id  }}" name="id">
                <input type="hidden" value="{{ $item->id  }}" name="certificate_id">
                <x-forms.primary-button>
                    {{ __('Изменить') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.form>

</div>




