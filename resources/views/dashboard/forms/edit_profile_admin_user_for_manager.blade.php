<div class="formCabinet">
    <x-forms.form
        title=""
        subtitle=""
        action="{{ route('update.managerforuser') }}"
        method="POST"
    >
        <div class="c__flex pad_t30_important">
            <div class="c__flex_50 c__flex_50_left">

                {{--item - это просматириваемый user--}}
                @include('dashboard.reserve.manager_reserve', ['item' => $item])

            </div><!--.c__flex_50_left-->
            <div class="c__flex_50 c__flex_50_right">



            </div><!--.c__flex_50_right-->
        </div><!--.c__flex-->

        <div class="select__wrap">
                <select class="js-chosen" name="manager" placeholder="{{ __('Выберите менеджера') }}">

                    @if($item->manager)
                        <optgroup label="Закрепленный менеджер">
                            <option value="{{$item->manager->id}}">
                                {{  $item->manager->name }}</option>
                        </optgroup>
                    @else
                        <optgroup label="Закрепленный менеджер">
                            <option value="{{manager_reserve()->id}}">
                                {{manager_reserve()->name}}
                            </option>
                        </optgroup>
                    @endif
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
                <input type="hidden" value="{{ $item->id  }}" name="id">
                <x-forms.primary-button>
                    {{ __('Закрепить менеджера') }}
                </x-forms.primary-button>
            </div>
        </div>
        </div>
    </x-forms.form>

</div>



