<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('add.certificate') }}"
        method="POST"
    >


        <div class="text_input">
            <x-forms.text-input_fromLabel
                type="text"
                id="Title"
                name="title"
                placeholder="Заголовок"
                value="{{ (old('title'))?:'' }}"
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
                value="{{ (old('price'))?:'' }}"
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
                value="{{ (old('country_from'))?:'' }}"
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
                value="{{ (old('country_to'))?:'' }}"
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
                            :value="date('Y-m-d')"
                            :result-text="__('Добавить')"
                        />
                    </div>

            </div>
        </div>

        <div class="text_input">
            <select class="js-chosen" name="user">
                <optgroup label="Пользователи">
                    <option value="0">{{ __('Добавить сертификат') }}</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </optgroup>
            </select>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    $('.js-chosen').chosen({
                        width: '100%',
                        no_results_text: 'Совпадений не найдено',
                        placeholder_text_single: 'Выберите'
                    });
                });
            </script>

        </div>

        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $user->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Отправить') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.form>

</div>



