<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('update.manager.reserve') }}"
        method="POST"
    >
        <div class="select__wrap pad_t1_important">
            <div class="c__title_subtitle">
                <h3 class="F_h1">{{__('Назначить менеджером по умолчанию')}}</h3>
                <div class="F_h2 pad_t5"><span>{{__('Выберете менеджера, он будет назначен как основной менеджер по умолчанию.')}}</span></div>
            </div>
                <select class="js-chosen" name="manager" placeholder="{{ __('Выберите менеджера') }}">
                        <optgroup label="Менеджер по умолчанию">
                            <option value="{{  manager_reserve()->id }}">{{  manager_reserve()->name }}</option>
                        </optgroup>

                    <optgroup label="Менеджеры">
                        @foreach($managers as $manager)
                            <option value="{{$manager->id}}">
                                {{ $manager->name }}</option>
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

        <div class="slotButtons slotButtons__right pad_t15">
            <div class=" text_input w_30">
                <x-forms.primary-button>
                    {{ __('Менеджер по умолчанию') }}
                </x-forms.primary-button>
            </div>
        </div>
        </div>
    </x-forms.form>

</div>



