<div class="checkbox__js">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('add.senior') }}"
        method="POST"
    >

        <div class="chose_filter__button">
            <div class="text_input">
                <input type="hidden" name="ids" id="ids" value="">
                <div class="slotButtons slotButtons__right pad_t15">
                    <div class=" text_input w_30">
                        <x-forms.primary-button>
                            {{ __('Добавить РОП') }}
                        </x-forms.primary-button>
                    </div>
                </div>

            </div>
        </div>


    </x-forms.form>
</div>

