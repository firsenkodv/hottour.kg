{{-- Шаблон «Сертификаты» — вёрстка страницы /sertifikaty
     (App\Enums\Pages\ListTemplate::Certificates).

     Все тексты приходят из настроек страницы (админка: «Категории» →
     «Сертификаты», табы по блокам; App\MoonShine\Pages\CertificatesPage),
     $page — Domain\Certificate\ViewModels\CertificateViewModel::getPageData().

     Не редактируются картинки: public/images/landing/certificates —
     подставляются по порядковому номеру карточки (нумерация = блок макета).

     Базовые классы (landing__inner, landing__hero, landing__btn, landing__cta)
     общие с лендингом «О нас» — pages/landing/landing.scss, своё — в
     pages/certificates/certificates.scss.

     Переключение «Физическим/Юридическим лицам» и выбор номинала — на
     radio-инпутах, без js.

     Вёрстка по макету Figma: docs/figma/certificate/1-6.png --}}

@php($img = 'images/landing/certificates')

<div class="landing landing--certificates">

    {{-- 1. Первый экран. Фон задан инлайном через asset(): url() из scss
         в dev-режиме vite уходит на dev-сервер (5173) и режется mixed content'ом --}}
    <section class="landing__hero cert__hero"
             style="background-image: linear-gradient(180deg, rgba(10, 10, 14, 0.35) 0%, rgba(10, 10, 14, 0.55) 62%, rgba(10, 10, 14, 0.92) 100%), url('{{ asset($img.'/1-hero.jpg') }}')">
        <div class="landing__inner">

            <div class="landing__crumbs">
                {{ Breadcrumbs::render(Route::currentRouteName()) }}
            </div>

            <h1 class="landing__title">{!! $page->hero_title ?: 'Подарочные сертификаты' !!}</h1>

            @if($page->hero_lead)
                <p class="landing__lead cert__hero-lead">{!! nl2br(e($page->hero_lead)) !!}</p>
            @endif

        </div>
    </section>

    {{-- 2-3. Переключатель аудитории и содержимое вкладок --}}
    <section class="cert">
        <div class="landing__inner">

            {{-- инпуты идут до панелей: активная вкладка выбирается
                 соседними селекторами (~) в certificates.scss --}}
            <input type="radio" name="cert_audience" id="cert_audience_person" class="cert__radio" checked>
            <input type="radio" name="cert_audience" id="cert_audience_company" class="cert__radio">

            <div class="cert__switch">
                <label class="cert__switch-item" for="cert_audience_person">{{ $page->person_switch ?: 'Физическим лицам' }}</label>
                <label class="cert__switch-item" for="cert_audience_company">{{ $page->company_switch ?: 'Юридическим лицам' }}</label>
            </div>

            <div class="cert__panels">

                {{-- вкладка «Физическим лицам» --}}
                <div class="cert__panel cert__panel--person" data-audience="{{ $page->person_switch ?: 'Физическим лицам' }}">

                    <h2 class="cert__h2">{!! $page->person_title !!}</h2>

                    @if($page->person_lead)
                        <p class="cert__lead">{!! nl2br(e($page->person_lead)) !!}</p>
                    @endif

                    @if(!empty($page->person_cards))
                        <ul class="cert__persons">
                            @foreach($page->person_cards as $card)
                                @continue(empty($card['label']))
                                <li class="cert__person">
                                    @if(!empty($card['img']))
                                        <img src="{{ asset('storage/'.$card['img']) }}" width="148" height="148" loading="lazy"
                                             alt="{{ $card['label'] }}">
                                    @endif
                                    <span class="cert__person-label">{{ $card['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- низ карты растворяется в фон секции — маска-градиент
                         рисуется через ::after (см. certificates.scss) --}}
                    <div class="cert__card">
                        <img src="{{ asset($img.'/3-card.jpg') }}" width="1078" height="534" loading="lazy"
                             alt="Подарочный сертификат HOT TOUR">
                    </div>

                    @if(!empty($page->person_sums))
                        <div class="cert__sums">
                            @foreach($page->person_sums as $sum)
                                @continue(empty($sum['value']))
                                <input type="radio" name="cert_sum_person" id="cert_sum_person_{{ $loop->iteration }}"
                                       class="cert__sum-radio" @checked($loop->first)>
                                <label class="cert__sum" for="cert_sum_person_{{ $loop->iteration }}">{{ $sum['value'] }}</label>
                            @endforeach
                        </div>
                    @endif

                    {{-- произвольная сумма: цифры форматируются по три
                         (10 000 000), выбор номинала при вводе снимается —
                         см. resources/js/certificates.js --}}
                    <div class="cert__custom">
                        <label class="cert__custom-label" for="cert_custom_person">
                            {{ $page->person_custom_label ?: 'Укажите сумму' }}
                        </label>
                        <span class="cert__custom-field">
                            <input type="text" id="cert_custom_person" class="cert__custom-input"
                                   inputmode="numeric" autocomplete="off" placeholder="0">
                            <span class="cert__custom-currency">₸</span>
                        </span>
                    </div>

                    @if($page->person_btn)
                        <div class="cert__action">
                            {{-- certificate_order_button_js подставляет в форму
                                 тип сертификата и выбранный номинал --}}
                            <a class="landing__btn landing__btn--primary certificate_order_button_js"
                               href="{{ $page->person_btn_url ?: '#certificate_order' }}"
                               @if(str_starts_with($page->person_btn_url ?: '#certificate_order', '#')) data-fancybox data-touch="false" @endif
                            >{{ $page->person_btn }}</a>
                        </div>
                    @endif

                </div>

                {{-- вкладка «Юридическим лицам» --}}
                <div class="cert__panel cert__panel--company" data-audience="{{ $page->company_switch ?: 'Юридическим лицам' }}">

                    <h2 class="cert__h2">{!! $page->company_title !!}</h2>

                    @if($page->company_lead)
                        <p class="cert__lead">{!! nl2br(e($page->company_lead)) !!}</p>
                    @endif

                    @if(!empty($page->company_cards))
                        <ul class="cert__persons">
                            @foreach($page->company_cards as $card)
                                @continue(empty($card['label']))
                                <li class="cert__person">
                                    @if(!empty($card['img']))
                                        <img src="{{ asset('storage/'.$card['img']) }}" width="148" height="148" loading="lazy"
                                             alt="{{ $card['label'] }}">
                                    @endif
                                    <span class="cert__person-label">{{ $card['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="cert__card">
                        <img src="{{ asset($img.'/3-card.jpg') }}" width="1078" height="534" loading="lazy"
                             alt="Подарочный сертификат HOT TOUR для юридических лиц">
                    </div>

                    @if(!empty($page->company_sums))
                        <div class="cert__sums">
                            @foreach($page->company_sums as $sum)
                                @continue(empty($sum['value']))
                                <input type="radio" name="cert_sum_company" id="cert_sum_company_{{ $loop->iteration }}"
                                       class="cert__sum-radio" @checked($loop->first)>
                                <label class="cert__sum" for="cert_sum_company_{{ $loop->iteration }}">{{ $sum['value'] }}</label>
                            @endforeach
                        </div>
                    @endif

                    <div class="cert__custom">
                        <label class="cert__custom-label" for="cert_custom_company">
                            {{ $page->company_custom_label ?: 'Укажите сумму' }}
                        </label>
                        <span class="cert__custom-field">
                            <input type="text" id="cert_custom_company" class="cert__custom-input"
                                   inputmode="numeric" autocomplete="off" placeholder="0">
                            <span class="cert__custom-currency">₸</span>
                        </span>
                    </div>

                    @if($page->company_btn)
                        <div class="cert__action">
                            <a class="landing__btn landing__btn--primary certificate_order_button_js"
                               href="{{ $page->company_btn_url ?: '#certificate_order' }}"
                               @if(str_starts_with($page->company_btn_url ?: '#certificate_order', '#')) data-fancybox data-touch="false" @endif
                            >{{ $page->company_btn }}</a>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    {{-- 4. Как это работает --}}
    @if(!empty($page->how_steps))
        <section class="cert__how">
            <div class="landing__inner">

                <h2 class="landing__h2 landing__h2--serif landing__h2--light">{!! $page->how_title !!}</h2>

                <ol class="cert__steps">
                    @foreach($page->how_steps as $step)
                        @continue(empty($step['title']))
                        <li class="cert__step">
                            <span class="cert__step-num">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="cert__step-title">{{ $step['title'] }}</span>
                            <span class="cert__step-text">{{ $step['text'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ol>

            </div>
        </section>
    @endif

    {{-- 5. Поводы: подписи выводятся html'ом поверх фото
         (в макете они были вшиты в картинку) --}}
    @if(!empty($page->reasons_cards))
        <section class="cert__reasons">
            <div class="landing__inner">

                <h2 class="cert__reasons-title">{!! $page->reasons_title !!}</h2>

                <ul class="cert__reasons-list">
                    @foreach($page->reasons_cards as $reason)
                        @continue(empty($reason['label']))
                        <li class="cert__reason">
                            @if($loop->iteration <= 4)
                                <img src="{{ asset($img.'/5-'.$loop->iteration.'.jpg') }}" width="277" height="323" loading="lazy"
                                     alt="{{ $reason['label'] }}">
                            @endif
                            <span class="cert__reason-label">{{ $reason['label'] }}</span>
                        </li>
                    @endforeach
                </ul>

            </div>
        </section>
    @endif

    {{-- 6. Свяжитесь напрямую. Подложка — фон блока index_questions с главной
         (base64 в questions.scss), поэтому секция несёт его класс.
         Телефон и ссылки мессенджеров — из «Настроек сайта» ($setting, SettingComposer),
         здесь только подписи --}}
    <section class="index_questions landing__cta cert__contacts">
        <div class="landing__inner">

            <h2 class="landing__h2 landing__h2--serif landing__h2--light">{!! $page->contacts_title !!}</h2>

            <div class="landing__cta-contacts">
                <div class="landing__cta-phone">
                    @if($page->contacts_phone_label)
                        <span class="landing__cta-label">{{ $page->contacts_phone_label }}</span>
                    @endif
                    {!! (isset($setting['phone2'])) ? $setting['phone2'] : '' !!}
                </div>

                <div class="landing__cta-social">
                    @if($page->contacts_social_label)
                        <span class="landing__cta-label">{{ $page->contacts_social_label }}</span>
                    @endif
                    <span class="landing__cta-icons">
                        <a class="landing__cta-icon landing__cta-icon--wa" target="_blank"
                           href="{!! (isset($setting['whatsapp'])) ? $setting['whatsapp'] : '' !!}">
                            <img alt="whatsapp" width="20" height="21" loading="lazy"
                                 src="{{ asset('images/inline/include-module-index-questions-1.svg') }}">
                        </a>
                        <a class="landing__cta-icon landing__cta-icon--tg" target="_blank"
                           href="{!! (isset($setting['telegram'])) ? $setting['telegram'] : '' !!}">
                            <img alt="telegram" width="19" height="16" loading="lazy"
                                 src="{{ asset('images/inline/include-module-index-questions-2.svg') }}">
                        </a>
                    </span>
                </div>
            </div>

        </div>
    </section>

    {{-- 7. Вопрос/Ответ — тот же компонент x-modules.faq, что в лендинге «О нас»
         (админка: «Сертификаты» → «Вопрос/Ответ») --}}
    @if(!empty($page->faq))
        <x-modules.faq :items="$page->faq" />
    @endif

    {{-- 8. Описание раздела (админка: «Сертификаты» → «Общие настройки»).
         Длинный текст сворачивается до первого абзаца с кнопкой «Читать далее»
         (<x-content.collapse>), как в лендинге «О нас» --}}
    @if($page->desc)
        <section class="landing__desc">
            <div class="landing__inner">
                <x-content.collapse>
                    <div class="content_page__desc desc_text desc">
                        {!! shortcode($page->desc) !!}
                    </div>
                </x-content.collapse>
            </div>
        </section>
    @endif

</div>
