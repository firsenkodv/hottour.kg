<div class="formCabinet pad_b32_important filter_form checkbox__js">
    <x-forms.form
        action="{{ route('filter.users_for_manager') }}"
        method="POST"
    >

<div class="chose_filter flex">

    <div class="chose_filter__user_fix">
        <div class="text_input">
            <select class="js-chosen" name="fix">


                <optgroup label="Менеджеры">
                    <option value="0">{{ __('Закрепить за менеджером') }}</option>

                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach

                </optgroup>
            </select>


        </div>
    </div>

    <div class="chose_filter__button">
        <div class="text_input">
            <input type="hidden" name="ids" id="ids" value="">
        <x-forms.primary-button>
            {{ __('Применить') }}
        </x-forms.primary-button>
        </div>
    </div>


</div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('.js-chosen').chosen({
                    width: '100%',
                    no_results_text: 'Совпадений не найдено',
                    placeholder_text_single: 'Выберите'
                });

            });
        </script>


    </x-forms.form>

</div>



