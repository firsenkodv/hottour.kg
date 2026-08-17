{{-- Лендинговое содержимое заглавной страницы раздела «О нас».
     Выбирается в админке: «Раздел О нас» → «Заглавная страница» →
     «Шаблон вывода» → «Лендинг» (App\Enums\Pages\ListTemplate::Landing).

     Все тексты приходят из настроек страницы (админка: «Заглавная страница»,
     табы по блокам; App\MoonShine\Pages\AboutPage), $page —
     Domain\Dump2\ViewModels\Dump2ViewModel::getPageData().

     Не редактируются:
     — видео: то же, что на главной в «Почему выбирают нас?»
       (public/video/hottour.mp4 + постер, include/module/index_video.blade.php);
     — иконки, скрины телефонов и 3d-картинки: public/images/landing/about,
       подставляются по порядковому номеру карточки (нумерация = блок макета).

     Вёрстка по макету Figma: docs/figma/about/desktop/1-6.png --}}

@php($img = 'images/landing/about')

<div class="landing landing--about">

    {{-- 1. Первый экран: заголовок, кнопки, статистика.
         Фон задан инлайном через asset(): url() из scss в dev-режиме vite
         уходит на dev-сервер (5173) и режется mixed content'ом --}}
    <section class="landing__hero"
             style="background-image: linear-gradient(180deg, rgba(16, 30, 27, 0.68) 0%, rgba(16, 30, 27, 0.5) 55%, rgba(16, 30, 27, 0.72) 100%), url('{{ asset('images/landing/about/1-all.jpg') }}')">
        <div class="landing__inner">

            <div class="landing__crumbs">
                {{ Breadcrumbs::render(Route::currentRouteName()) }}
            </div>

            <h1 class="landing__title">{!! $page->hero_title ?: 'О нас' !!}</h1>

            @if($page->hero_lead)
                <p class="landing__lead">{!! nl2br(e($page->hero_lead)) !!}</p>
            @endif

            @if(!empty($page->hero_buttons))
                <div class="landing__actions">
                    @foreach($page->hero_buttons as $btn)
                        @continue(empty($btn['text']))
                        {{-- ссылка на якорь (#pick_tour и т.п.) — это модалка fancybox --}}
                        <a class="landing__btn {{ $loop->first ? 'landing__btn--primary' : 'landing__btn--ghost' }}"
                           href="{{ $btn['url'] ?? '#' }}"
                           @if(str_starts_with($btn['url'] ?? '', '#')) data-fancybox data-touch="false" @endif
                        >{{ $btn['text'] }}</a>
                    @endforeach
                </div>
            @endif

            @if(!empty($page->hero_stats))
                <ul class="landing__stats">
                    @foreach($page->hero_stats as $stat)
                        @continue(empty($stat['value']))
                        <li class="landing__stat">
                            @if($loop->iteration <= 3)
                                <span class="landing__stat-icon"><img src="{{ asset($img.'/1-Icon'.$loop->iteration.'.svg') }}" width="56" height="56" loading="lazy" alt=""></span>
                            @elseif($loop->iteration === 4)
                                {{-- 1-Icon4 экспортирован из фигмы растром — остальные иконки svg --}}
                                <span class="landing__stat-icon"><img src="{{ asset($img.'/1-Icon4.png') }}" width="56" height="56" loading="lazy" alt=""></span>
                            @endif
                            <span class="landing__stat-value">{{ $stat['value'] }}</span>
                            <span class="landing__stat-label">{{ $stat['label'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </section>

    {{-- 2. О компании: текст с галочками + фото --}}
    <section class="landing__company">
        <div class="landing__inner">
            <div class="landing__company-grid">

                <div class="landing__company-info">
                    <h2 class="landing__h2">{!! $page->company_title !!}</h2>

                    @if($page->company_text)
                        <p class="landing__text">{{ $page->company_text }}</p>
                    @endif

                    @if(!empty($page->company_checks))
                        <ul class="landing__checklist">
                            @foreach($page->company_checks as $check)
                                @continue(empty($check['title']))
                                <li class="landing__check">
                                    <span class="landing__check-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10.8" stroke="#16A34A" stroke-width="2"/><path d="m8 12.2 2.7 2.7L16 9.6" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                    <span class="landing__check-body">
                                        <strong>{{ $check['title'] }}</strong>
                                        {{ $check['text'] ?? '' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="landing__company-photo">
                    <img src="{{ asset($img.'/2.jpg') }}" width="552" height="384" loading="lazy"
                         alt="Команда HotTour">
                </div>

            </div>
        </div>
    </section>

    {{-- 3. Наши преимущества: видео + карточки, фон-фото (инлайн — см. hero) --}}
    <section class="landing__advantages"
             style="background-image: linear-gradient(180deg, rgba(7, 38, 36, 0.78) 0%, rgba(7, 38, 36, 0.6) 100%), url('{{ asset('images/landing/about/3-all.jpg') }}')">
        <div class="landing__inner">

            <h2 class="landing__h2 landing__h2--serif landing__h2--light">{!! $page->adv_title !!}</h2>
            @if($page->adv_lead)
                <p class="landing__lead landing__lead--light">{!! nl2br(e($page->adv_lead)) !!}</p>
            @endif

            <div class="landing__video">
                <video controls preload="none" width="1120" height="560"
                       poster="{{ asset('/video/poster.jpg') }}" onclick="this.play();">
                    <source src="{{ asset('/video/hottour.mp4') }}" type="video/mp4">
                    Ваш браузер не поддерживает встроенные видео :(
                </video>
            </div>

            @if(!empty($page->adv_cards))
                <ul class="landing__advcards">
                    @foreach($page->adv_cards as $card)
                        @continue(empty($card['title']))
                        <li class="landing__advcard">
                            @if($loop->iteration <= 6)
                                <span class="landing__advcard-icon"><img src="{{ asset($img.'/3-Icon'.$loop->iteration.'.svg') }}" width="28" height="28" loading="lazy" alt=""></span>
                            @endif
                            <span class="landing__advcard-title">{{ $card['title'] }}</span>
                            <span class="landing__advcard-text">{{ $card['text'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </section>

    {{-- 4. Мобильное приложение: сторы, фичи, скрины --}}
    <section class="landing__app">
        <div class="landing__inner">

            <h2 class="landing__h2 landing__h2--serif">{!! $page->app_title !!}</h2>
            @if($page->app_lead)
                <p class="landing__lead landing__lead--dark">{!! nl2br(e($page->app_lead)) !!}</p>
            @endif

            {{-- ссылки открывают ту же QR-модалку #gr-app,
                 что и бейджи в футере (components/mobile_app) --}}
            <div class="landing__stores">
                <a data-fancybox href="#gr-app" class="landing__store">
                    <svg width="20" height="24" viewBox="0 0 20 24" fill="none"><path d="M16.365 12.77c.03 3.25 2.852 4.33 2.883 4.344-.024.076-.451 1.542-1.487 3.055-.896 1.309-1.826 2.613-3.29 2.64-1.44.027-1.903-.853-3.548-.853-1.646 0-2.16.826-3.522.88-1.414.053-2.49-1.415-3.393-2.719C2.163 17.45.752 12.582 2.646 9.303c.94-1.628 2.622-2.66 4.447-2.686 1.388-.027 2.699.934 3.548.934.848 0 2.44-1.155 4.115-.985.7.029 2.667.283 3.93 2.132-.102.063-2.347 1.37-2.321 4.072ZM13.66 4.8c.75-.909 1.256-2.173 1.118-3.432-1.082.044-2.39.721-3.166 1.629-.696.804-1.305 2.09-1.14 3.324 1.205.093 2.437-.613 3.188-1.521Z" fill="#000"/></svg>
                    <span class="landing__store-label"><small>Доступно в</small> App Store</span>
                </a>
                <a data-fancybox href="#gr-app" class="landing__store">
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none"><path d="M1.05.61C.75.93.57 1.42.57 2.06v17.88c0 .64.18 1.13.48 1.44l.08.07 10.02-10.01v-.24L1.13.53l-.08.08Z" fill="#000"/><path d="m14.49 14.79-3.34-3.35v-.24l3.34-3.34.08.05 3.96 2.25c1.13.64 1.13 1.69 0 2.34l-3.96 2.24-.08.05Z" fill="#000"/><path d="m14.57 14.74-3.42-3.4L1.05 21.38c.37.4.99.44 1.68.05l11.84-6.7" fill="#000"/><path d="M14.57 7.91 2.73.71C2.04.32 1.42.37 1.05.77l10.1 10.05 3.42-3.4Z" fill="#000"/></svg>
                    <span class="landing__store-label"><small>Скачайте в</small> Google Play</span>
                </a>
            </div>

            @if(!empty($page->app_features))
                <ul class="landing__features">
                    @foreach($page->app_features as $feature)
                        @continue(empty($feature['title']))
                        <li class="landing__feature">
                            @if($loop->iteration <= 4)
                                <span class="landing__feature-icon"><img src="{{ asset($img.'/4-Icon'.$loop->iteration.'.svg') }}" width="48" height="48" loading="lazy" alt=""></span>
                            @endif
                            <span class="landing__feature-title">{{ $feature['title'] }}</span>
                            <span class="landing__feature-text">{{ $feature['text'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- низ скринов растворяется в фон секции — маска-градиент
                 рисуется через ::after (см. landing.scss) --}}
            <div class="landing__phones">
                <img src="{{ asset($img.'/4-1.png') }}" width="260" height="530" loading="lazy" alt="Поиск туров в приложении HotTour">
                <img src="{{ asset($img.'/4-2.png') }}" width="260" height="530" loading="lazy" alt="Подбор тура на карте">
                <img src="{{ asset($img.'/4-3.png') }}" width="260" height="530" loading="lazy" alt="Мои документы">
                <img src="{{ asset($img.'/4-4.png') }}" width="260" height="530" loading="lazy" alt="Мои туры">
            </div>

        </div>
    </section>

    {{-- 5. Онлайн-оформление: степпер и карточки --}}
    <section class="landing__online">
        <div class="landing__inner">
            <div class="landing__online-box">

                <h2 class="landing__h2 landing__h2--serif">{!! $page->online_title !!}</h2>
                @if($page->online_lead)
                    <p class="landing__lead landing__lead--dark">{!! nl2br(e($page->online_lead)) !!}</p>
                @endif

                @if(!empty($page->online_steps))
                    <ol class="landing__steps">
                        @foreach($page->online_steps as $step)
                            @continue(empty($step['label']))
                            <li class="landing__step">
                                <span class="landing__step-num">{{ $loop->iteration }}</span>
                                <span class="landing__step-label">{{ $step['label'] }}</span>
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if(!empty($page->online_cards))
                    <ul class="landing__stepcards">
                        @foreach($page->online_cards as $card)
                            @continue(empty($card['title']))
                            <li class="landing__stepcard">
                                <span class="landing__stepcard-title">{{ $card['title'] }}</span>
                                <span class="landing__stepcard-text">{{ $card['text'] ?? '' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </section>

    {{-- 6. Путешествовать с нами безопасно: карточки с 3d-картинками.
         Картинки 6-1..6-4 вырезаны из макета (docs/figma/about/desktop/6.png),
         фон текстовой части карточки подобран пипеткой под фон вырезки --}}
    <section class="landing__safety">
        <div class="landing__inner">

            <h2 class="landing__h2 landing__h2--serif">{!! $page->safety_title !!}</h2>
            @if($page->safety_lead)
                <p class="landing__lead landing__lead--dark">{{ $page->safety_lead }}</p>
            @endif

            @if(!empty($page->safety_cards))
                <ul class="landing__safecards">
                    @foreach($page->safety_cards as $card)
                        @continue(empty($card['title']))
                        <li class="landing__safecard">
                            <span class="landing__safecard-body">
                                <span class="landing__safecard-title">{{ $card['title'] }}</span>
                                <span class="landing__safecard-text">{{ $card['text'] ?? '' }}</span>
                            </span>
                            @if($loop->iteration <= 4)
                                <img src="{{ asset($img.'/6-'.$loop->iteration.'.png') }}" width="266" height="257" loading="lazy" alt="">
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    </section>

    {{-- 7. Отзывы — тот же слайдер r_sw, что на главной (x-modules.responses);
         тизер карточки: поля trip_date/adults/rating модели Company --}}
    <section class="landing__responses">
        <div class="landing__inner">
            <x-modules.responses />
        </div>
    </section>

    {{-- 8. Вопрос/Ответ — компонент x-modules.faq, перенесён из generalre
         (вёрстка, стили и js-аккордеон один в один) --}}
    <x-modules.faq :items="$page->faq ?? []" />

    {{-- 9. Призыв к действию (блок 8 макета).
         Подложка — фон блока index_questions с главной (base64 в questions.scss),
         поэтому секция несёт его класс. Телефон и ссылки мессенджеров —
         из «Настроек сайта» ($setting, SettingComposer), здесь только подписи --}}
    <section class="index_questions landing__cta">
        <div class="landing__inner">

            <h2 class="landing__h2 landing__h2--serif landing__h2--light">{!! $page->cta_title !!}</h2>
            @if($page->cta_lead)
                <p class="landing__lead landing__lead--light">{{ $page->cta_lead }}</p>
            @endif

            @if(!empty($page->cta_buttons))
                <div class="landing__actions">
                    @foreach($page->cta_buttons as $btn)
                        @continue(empty($btn['text']))
                        <a class="landing__btn {{ $loop->first ? 'landing__btn--primary' : 'landing__btn--ghost' }}"
                           href="{{ $btn['url'] ?? '#' }}"
                           @if(str_starts_with($btn['url'] ?? '', '#')) data-fancybox data-touch="false" @endif
                        >{{ $btn['text'] }}</a>
                    @endforeach
                </div>
            @endif

            <div class="landing__cta-contacts">
                <div class="landing__cta-phone">
                    @if($page->cta_phone_label)
                        <span class="landing__cta-label">{{ $page->cta_phone_label }}</span>
                    @endif
                    {!! (isset($setting['phone2'])) ? $setting['phone2'] : '' !!}
                </div>

                <div class="landing__cta-social">
                    @if($page->cta_social_label)
                        <span class="landing__cta-label">{{ $page->cta_social_label }}</span>
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

    {{-- 10. Описание раздела (админка: «Заглавная страница» → «Общие»).
         Длинный текст сворачивается до первого абзаца с кнопкой «Читать далее»
         (<x-content.collapse>, принцип перенесён из hseipaa.kz) --}}
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
