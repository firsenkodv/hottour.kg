<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('add.important') }}"
        method="POST"
    >


                    <div class="text_input">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="importantTitle"
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
                            id="importantSubTitle"
                            name="subtitle"
                            placeholder="Подзаголовок"
                            class="input subtitle"
                            value="{{ (old('subtitle'))?:'' }}"
                            :isError="$errors->has('subtitle')"
                        />
                        <x-forms.error class="error_subtitle"/>

                    </div>

        <div class="c__title_subtitle">
            <h3 class="F_h1">{{ __('Краткое описание') }}</h3>
            <div class="F_h2 pad_t5"><span>{{__('Описание будет выводиться анонсом.')}}</span></div>
        </div>


        <div class="text_input">
        <x-forms.textarea-tyni
            id="Short_desc"
            name="short_desc"

        >
            {!! (old('short_desc')?:'') !!}
        </x-forms.textarea-tyni>
        </div>
            <br>
            <hr>
        <div class="c__title_subtitle">
            <h3 class="F_h1">{{ __('Полное описание') }}</h3>
            <div class="F_h2 pad_t5"><span>{{__('Описание будет выводиться на отдельной странице.')}}</span></div>
        </div>


        <div class="text_input">
        <x-forms.textarea-tyni
            id="Text"
            name="text"
        >
            {!! (old('text')?:'') !!}
        </x-forms.textarea-tyni>



        </div>
        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <input type="hidden" value="{{ $user->id  }}" name="user_id">
                <x-forms.primary-button>
                    {{ __('Отправить') }}
                </x-forms.primary-button>
            </div>
        </div>

    </x-forms.form>

    </div>


