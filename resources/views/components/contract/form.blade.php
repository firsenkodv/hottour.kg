@props(['contractRooms' => [], 'contractFoods' => []])
<style>

</style>
<div id="m_contract_form" style="display: none;">
    <x-forms.loader class="br_12"/>
    <div class="pad_24">
    <div class="formCabinet">

        <div class="F_responce" style="display:none;">
            <div class="af-message">
                <p class="font_24">Готово</p>
                <p class="ic_done"><img width="80" height="80" alt=""
                                        src="{{ asset('images/inline/components-contract-form-1.png') }}">
                </p>
                <p id="cf_success_msg" class="ccent"></p>
                <a id="cf_copy_link" href="javascript:;" class="contract-copy-link" data-url="" style="display:none; text-decoration: none; margin-top:12px; font-size:15px;">
                    🔗 Скопировать ссылку на договор
                </a>
            </div>
        </div>

        <div class="F_form__body">

            {{-- Заголовок: режим создания --}}
            <div class="c__title_subtitle pad_t1_important" id="cf_head_create">
                <h3 class="F_h1">{{ __('Новый договор') }}</h3>
                <div class="F_h2 pad_t5"><span>{{ __('У вас есть право создать договор с пользователем.') }}</span></div>
            </div>

            {{-- Заголовок: режим просмотра/редактирования --}}
            <div class="c__title_subtitle pad_t1_important" id="cf_head_edit" style="display:none;">
                <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                    <div>
                        <h3 class="F_h1">{{ __('Договор') }} № <span id="cf_number"></span></h3>
                        <div class="F_h2 pad_t5"><span id="cf_badge"></span></div>
                    </div>
                    <a id="cf_public_link" href="#" target="_blank" class="button button_normal pad_l16 pad_r16" style="font-size:16px;margin: 10px 0">
                        {{ __('Открыть договор') }}
                    </a>
                </div>
            </div>

            <form id="form_contract" class="form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="cf_method" value="POST">
                <input type="hidden" id="cf_contract_id">
                <input type="hidden" name="user_id" id="cf_user_id">

                {{-- Заголовок / заметка --}}
                <div class="text_input">
                                              <x-forms.text-input_fromLabel
                                type="text"
                                id="cf_title"
                                name="title"
                                placeholder="{{ __('Заголовок') }}"
                                value=""
                                class="input"
                            />

                        <p class="field_hint">{{ __('Поле не обязательное. Видите его только вы — это заметка о клиенте или договоре.') }}</p>

                </div>

                {{-- Клиент --}}
                <div class="text_input">
                    <div class="ac-select" id="cf_acUser">
                        <input
                            type="text"
                            id="cf_user_display"
                            class="input inputClass ac-select__input"
                            autocomplete="off"
                        >
                        <label class="labelInput" for="cf_user_display">{{ __('Поиск клиента...') }}</label>
                        <div class="ac-select__dropdown" id="cf_userDropdown"></div>
                    </div>
                    <x-forms.error class="error_user_id"/>
                </div>

                {{-- Паспортные данные клиента --}}
                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="cf_passport"
                        name="passport"
                        placeholder="{{ __('Паспорт №') }}"
                        value=""
                        class="input"
                    />
                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="cf_passport_issued_at"
                        name="passport_issued_at"
                        placeholder="{{ __('Выдано') }}"
                        value=""
                        class="input"
                    />
                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="cf_passport_issued_by"
                        name="passport_issued_by"
                        placeholder="{{ __('Кем') }}"
                        value=""
                        class="input"
                    />
                </div>

                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="cf_inn"
                        name="inn"
                        placeholder="{{ __('ИИН') }}"
                        value=""
                        class="input"
                    />
                </div>

                {{-- Города --}}
                <div class="text_input text_input_row">
                    <div class="text_input_row__col text_input_row__col__top">
                        <div class="ac-select" id="cf_acCityDep">
                            <input type="text" id="cf_city_dep_display" class="input inputClass ac-select__input" autocomplete="off">
                            <label class="labelInput" for="cf_city_dep_display">{{ __('Город вылета') }}</label>
                            <input type="hidden" name="city_departure" id="cf_city_dep">
                            <div class="ac-select__dropdown" id="cf_cityDepDropdown"></div>
                        </div>
                    </div>
                    <div class="text_input_row__col text_input_row__col__bottom">
                        <div class="ac-select" id="cf_acCityArr">
                            <input type="text" id="cf_city_arr_display" class="input inputClass ac-select__input" autocomplete="off">
                            <label class="labelInput" for="cf_city_arr_display">{{ __('Город прилёта') }}</label>
                            <input type="hidden" name="city_arrival" id="cf_city_arr">
                            <div class="ac-select__dropdown" id="cf_cityArrDropdown"></div>
                        </div>
                    </div>
                </div>

                {{-- Даты --}}
                <div class="text_input text_input_row">
                    <div class=" text_input_row__col text_input_row__col__top">
                        <div class="birthdate_wrap">
                            <div class="birthdate">
                                <span>{{ __('Дата вылета') }}</span>
                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="date_departure"
                                    input-id="cf_date_dep"
                                    result-id="cf_date_dep_result"
                                    :result-text="__('Выбрать')"
                                />
                            </div>
                        </div>
                        <x-forms.error class="error_date_departure"/>
                    </div>
                    <div class="text_input_row__col text_input_row__col__bottom">
                        <div class="birthdate_wrap">
                            <div class="birthdate">
                                <span>{{ __('Дата прилёта') }}</span>
                                <x-forms.datepicker
                                    mode="birthdate"
                                    name="date_arrival"
                                    input-id="cf_date_arr"
                                    result-id="cf_date_arr_result"
                                    :result-text="__('Выбрать')"
                                />
                            </div>
                        </div>
                        <x-forms.error class="error_date_arrival"/>
                    </div>
                </div>

                {{-- Количество дней --}}
                <div class="text_input birthdate_result-">
                    <input type="hidden" id="cf_days" name="days_count" value="0">
                    <div class="birthdate_wrap">
                        <div class="birthdate">
                            <span>{{ __('Количество дней') }}</span>
                            <div class="birthdate_pic">
                                <a href="javascript:void(0);" id="cf_days_result" class="datepicker-birthdate_result">0</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Отель (поиск) --}}
                <div class="text_input">
                    <div class="ac-select" id="cf_acHotel">
                        <input type="text" id="cf_hotel_display" class="input inputClass ac-select__input" autocomplete="off">
                        <label class="labelInput" for="cf_hotel_display">{{ __('Поиск отеля...') }}</label>
                        <input type="hidden" name="hotel_id" id="cf_hotel_id">
                        <div class="ac-select__dropdown" id="cf_hotelDropdown"></div>
                    </div>
                    <x-forms.error class="error_hotel_id"/>
                </div>

                {{-- Отель вручную --}}
                <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                id="cf_hotel_custom"
                                name="hotel_custom"
                                placeholder="{{ __('Или введите отель вручную') }}"
                                value=""
                                class="input"
                            />
                </div>

                {{-- Стоимость --}}
                <div class="text_input input_suffix_wrap">
                        <x-forms.text-input_fromLabel
                            type="text"
                            id="cf_price_display"
                            placeholder="{{ __('Стоимость тура') }}"
                            value=""
                            class="input cf_price_display"
                            inputmode="numeric"
                            autocomplete="off"
                        />
                        <span class="input_suffix">₸</span>
                    <input type="hidden" id="cf_price" name="tour_price">
                    <x-forms.error class="error_tour_price"/>
                </div>

                {{-- Рамочный договор --}}
                <div class="text_input">
                    <x-forms.text-input_fromLabel
                        type="text"
                        id="cf_framework_url"
                        name="framework_url"
                        placeholder="{{ __('Рамочный договор (ссылка)') }}"
                        value="/o-nas/dokumenty/dogovor"
                        class="input"
                    />
                    <p class="field_hint">{{ __('Ссылка на статичный документ рамочного договора.') }}</p>
                </div>

                {{-- Номер (тип размещения) --}}
                <div class="text_input" id="cf_contract_room_id_wrap">
                    <label class="field_label">{{ __('Номер') }}</label>
                    <x-forms.select name="contract_room_id" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            @foreach($contractRooms as $room)
                                <li data-option="{{ $room->id }}" class="select__item">{{ $room->title }}</li>
                            @endforeach
                        </ul>
                    </x-forms.select>
                </div>

                {{-- Питание --}}
                <div class="text_input" id="cf_contract_food_id_wrap">
                    <label class="field_label">{{ __('Питание') }}</label>
                    <x-forms.select name="contract_food_id" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            @foreach($contractFoods as $food)
                                <li data-option="{{ $food->id }}" class="select__item">{{ $food->title }}</li>
                            @endforeach
                        </ul>
                    </x-forms.select>
                </div>

                {{-- Дополнительные услуги --}}
                <div class="text_input" id="cf_transfer_wrap">
                    <label class="field_label">{{ __('Трансфер') }}</label>
                    <x-forms.select name="transfer" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            <li data-option="yes" class="select__item">{{ __('Да') }}</li>
                            <li data-option="no" class="select__item">{{ __('Нет') }}</li>
                        </ul>
                    </x-forms.select>
                </div>

                <div class="text_input" id="cf_excursion_program_wrap">
                    <label class="field_label">{{ __('Экскурсионная программа') }}</label>
                    <x-forms.select name="excursion_program" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            <li data-option="yes" class="select__item">{{ __('Да') }}</li>
                            <li data-option="no" class="select__item">{{ __('Нет') }}</li>
                        </ul>
                    </x-forms.select>
                </div>

                <div class="text_input" id="cf_russian_speaking_guide_wrap">
                    <label class="field_label">{{ __('Русскоговорящий гид') }}</label>
                    <x-forms.select name="russian_speaking_guide" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            <li data-option="yes" class="select__item">{{ __('Да') }}</li>
                            <li data-option="no" class="select__item">{{ __('Нет') }}</li>
                        </ul>
                    </x-forms.select>
                </div>

                <div class="text_input" id="cf_visa_support_wrap">
                    <label class="field_label">{{ __('Визовая поддержка') }}</label>
                    <x-forms.select name="visa_support" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            <li data-option="yes" class="select__item">{{ __('Да') }}</li>
                            <li data-option="no" class="select__item">{{ __('Нет') }}</li>
                        </ul>
                    </x-forms.select>
                </div>

                <div class="text_input" id="cf_medical_support_wrap">
                    <label class="field_label">{{ __('Медицинская поддержка') }}</label>
                    <x-forms.select name="medical_support" value="" text="{{ __('Не указано') }}">
                        <ul class="select__list scroll-block" style="display: none;">
                            <li data-option="" class="select__item">{{ __('Не указано') }}</li>
                            <li data-option="yes" class="select__item">{{ __('Да') }}</li>
                            <li data-option="no" class="select__item">{{ __('Нет') }}</li>
                        </ul>
                    </x-forms.select>
                </div>

                {{-- Люди: взрослые --}}
                <div class="text_input">
                    <label class="field_label">{{ __('Взрослые') }}</label>
                    <div id="cf_adults_list">
                        <div class="cf_people_row" data-role="adult-row">
                            <input type="text" name="people[adults][0][fio]" class="input" placeholder="{{ __('ФИО') }}">
                            <a href="javascript:;" class="cf_remove_row">&times;</a>
                        </div>
                    </div>
                    <a href="javascript:;" class="cf_add_adult button_link" data-target="cf_adults_list">+ {{ __('Добавить взрослого') }}</a>
                </div>

                {{-- Люди: дети --}}
                <div class="text_input">
                    <label class="field_label">{{ __('Дети') }}</label>
                    <div id="cf_children_list">
                        <div class="cf_people_row cf_people_row_child" data-role="child-row">
                            <input  type="text" name="people[children][0][fio]" class="input" placeholder="{{ __('ФИО') }}">
                            <input type="text" name="people[children][0][age]" class="input cf_age_input" placeholder="{{ __('Возраст') }}">
                            <a href="javascript:;" class="cf_remove_row">&times;</a>
                        </div>
                    </div>
                    <a href="javascript:;" class="cf_add_child button_link" data-target="cf_children_list">+ {{ __('Добавить ребёнка') }}</a>
                </div>

                <div class="slotButtons slotButtons__right pad_t15" id="cf_submit_wrap">
                    <div class="text_input w_30">
                        <button type="button" class="button button_normal cf_submit_btn">
                            <span id="cf_submit_label">{{ __('Создать договор') }}</span>
                        </button>
                    </div>
                </div>

            </form>

        </div>{{-- /.F_form__body --}}

    </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function initAcSelect(wrap, url, renderLabel, hiddenInput, valueCallback, displayCallback, onSelect) {
        if (!wrap) return;
        var input    = wrap.querySelector('.ac-select__input');
        var dropdown = wrap.querySelector('.ac-select__dropdown');
        var timer;

        function getItems()  { return dropdown.querySelectorAll('.ac-select__item'); }
        function getActive() { return dropdown.querySelector('.ac-select__item.ac-active'); }

        function setActive(item) {
            getItems().forEach(function (el) { el.classList.remove('ac-active'); });
            if (item) { item.classList.add('ac-active'); item.scrollIntoView({ block: 'nearest' }); }
        }

        var label = wrap.querySelector('.labelInput');
        function syncLabel() {
            if (label) label.classList.toggle('show', input.value.trim() !== '');
        }

        function selectItem(item) {
            if (!item) return;
            var data      = JSON.parse(item.dataset.obj);
            hiddenInput.value = valueCallback ? valueCallback(data) : item.dataset.id;
            input.value       = displayCallback ? displayCallback(data) : item.textContent.trim();
            dropdown.innerHTML = '';
            dropdown.classList.remove('open');
            syncLabel();
            if (onSelect) onSelect(data);
        }

        input.addEventListener('input', function () {
            clearTimeout(timer);
            hiddenInput.value = '';
            syncLabel();
            var q = this.value.trim();
            if (q.length < 2) { dropdown.innerHTML = ''; dropdown.classList.remove('open'); return; }
            timer = setTimeout(function () {
                fetch(url + '?q=' + encodeURIComponent(q), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function (items) {
                        dropdown.innerHTML = items.length
                            ? items.map(function (item) {
                                return '<div class="ac-select__item" data-id="' + item.id + '" data-obj=\'' + JSON.stringify(item) + '\'>' + renderLabel(item) + '</div>';
                              }).join('')
                            : '<div class="ac-select__empty">Ничего не найдено</div>';
                        dropdown.classList.add('open');
                    })
                    .catch(function (err) {
                        console.error('Поиск не удался:', err);
                        dropdown.innerHTML = '<div class="ac-select__empty">Ошибка поиска. Попробуйте позже.</div>';
                        dropdown.classList.add('open');
                    });
            }, 300);
        });

        input.addEventListener('keydown', function (e) {
            if (!dropdown.classList.contains('open')) return;
            var items  = getItems();
            var active = getActive();
            var idx    = Array.prototype.indexOf.call(items, active);
            if      (e.key === 'ArrowDown')  { e.preventDefault(); setActive(items[idx + 1] || items[0]); }
            else if (e.key === 'ArrowUp')    { e.preventDefault(); setActive(idx > 0 ? items[idx - 1] : null); if (idx <= 0) input.focus(); }
            else if (e.key === 'Enter')      { e.preventDefault(); selectItem(active); }
            else if (e.key === 'Escape')     { dropdown.innerHTML = ''; dropdown.classList.remove('open'); }
        });

        dropdown.addEventListener('click', function (e) { selectItem(e.target.closest('.ac-select__item')); });

        document.addEventListener('click', function (e) {
            if (!wrap.contains(e.target)) { dropdown.innerHTML = ''; dropdown.classList.remove('open'); }
        });
    }

    function fillPassportFields(u) {
        ['passport', 'passport_issued_at', 'passport_issued_by', 'inn'].forEach(function (field) {
            var el = document.getElementById('cf_' + field);
            if (!el) return;
            el.value = u[field] || '';
            var lbl = document.querySelector('label[for="cf_' + field + '"]');
            if (lbl) lbl.classList.toggle('show', el.value !== '');
        });
    }

    initAcSelect(
        document.getElementById('cf_acUser'),
        '{{ route('contracts.users.search') }}',
        function (u) { return u.name + ' &mdash; ' + u.email + (u.phone ? ' &mdash; ' + u.phone : ''); },
        document.getElementById('cf_user_id'),
        null,
        function (u) { return u.name; },
        fillPassportFields
    );

    initAcSelect(
        document.getElementById('cf_acHotel'),
        '{{ route('contracts.hotels.search') }}',
        function (h) { return h.title; },
        document.getElementById('cf_hotel_id')
    );

    initAcSelect(
        document.getElementById('cf_acCityDep'),
        '{{ route('contracts.cities.search') }}',
        function (c) { return c.city_ru + ' &mdash; ' + c.country_ru; },
        document.getElementById('cf_city_dep'),
        function (c) { return c.city_ru; },
        function (c) { return c.city_ru; }
    );

    initAcSelect(
        document.getElementById('cf_acCityArr'),
        '{{ route('contracts.cities.search') }}',
        function (c) { return c.city_ru + ' &mdash; ' + c.country_ru; },
        document.getElementById('cf_city_arr'),
        function (c) { return c.city_ru; },
        function (c) { return c.city_ru; }
    );

    function calcDays() {
        var dep  = document.getElementById('cf_date_dep').value;
        var arr  = document.getElementById('cf_date_arr').value;
        if (dep && arr) {
            var diff = Math.round((new Date(arr) - new Date(dep)) / 86400000);
            if (diff >= 0) {
                document.getElementById('cf_days').value         = diff;
                document.getElementById('cf_days_result').textContent = diff;
            }
        }
    }

    // js/datepicker.js инициализирует .datepicker-birthdate и форматирует текст с locale('ru').
    // Здесь только пересчитываем количество дней при выборе даты.
    $('#cf_date_dep, #cf_date_arr').on('datepicker-change', function () {
        calcDays();
    });

    // Люди: взрослые / дети
    // Индексы строк должны быть явными (people[children][0][fio], [0][age], [1][fio]...),
    // иначе каждое поле "[]" получает СВОЙ порядковый номер и fio/age из одной строки
    // разъезжаются по разным элементам массива на стороне PHP.
    function reindexPeopleList(listId, type) {
        $('#' + listId).children('.cf_people_row').each(function (index) {
            $(this).find('input[name$="[fio]"]').attr('name', 'people[' + type + '][' + index + '][fio]');
            $(this).find('input[name$="[age]"]').attr('name', 'people[' + type + '][' + index + '][age]');
        });
    }

    $(document).on('click', '.cf_add_adult', function () {
        var listId = $(this).data('target');
        $('#' + listId).append(
            '<div class="cf_people_row" data-role="adult-row">' +
                '<input type="text" name="people[adults][][fio]" class="input" placeholder="{{ __('ФИО') }}">' +
                '<a href="javascript:;" class="cf_remove_row">&times;</a>' +
            '</div>'
        );
        reindexPeopleList(listId, 'adults');
    });

    $(document).on('click', '.cf_add_child', function () {
        var listId = $(this).data('target');
        $('#' + listId).append(
            '<div class="cf_people_row cf_people_row_child" data-role="child-row">' +
                '<input type="text" name="people[children][][fio]" class="input" placeholder="{{ __('ФИО') }}">' +
                '<input type="text" name="people[children][][age]" class="input cf_age_input" placeholder="{{ __('Возраст') }}">' +
                '<a href="javascript:;" class="cf_remove_row">&times;</a>' +
            '</div>'
        );
        reindexPeopleList(listId, 'children');
    });

    $(document).on('click', '.cf_remove_row', function () {
        var $row  = $(this).closest('.cf_people_row');
        var $list = $row.parent();
        var listId = $list.attr('id');
        var type   = listId === 'cf_adults_list' ? 'adults' : 'children';

        if ($list.children('.cf_people_row').length > 1) {
            $row.remove();
        } else {
            $row.find('input').val('');
        }
        reindexPeopleList(listId, type);
    });

    // Форматирование стоимости тура
    var priceDisplay = document.getElementById('cf_price_display');
    var priceHidden  = document.getElementById('cf_price');

    function formatPriceValue(raw) {
        return raw.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    if (priceDisplay) {
        priceDisplay.addEventListener('input', function () {
            var caret = this.selectionStart;
            var before = this.value.slice(0, caret).replace(/\D/g, '').length;
            var raw = this.value.replace(/\D/g, '');
            var formatted = formatPriceValue(raw);
            this.value = formatted;
            // восстанавливаем позицию курсора
            var pos = 0, digits = 0;
            for (var i = 0; i < formatted.length; i++) {
                if (/\d/.test(formatted[i])) digits++;
                if (digits === before) { pos = i + 1; break; }
            }
            this.setSelectionRange(pos, pos);
            priceHidden.value = raw;
            var lbl = document.querySelector('label[for="cf_price_display"]');
            if (lbl) lbl.classList.toggle('show', raw !== '');
        });
    }

});
</script>
