@section('tourvisor')
    {{-- daterangepicker.css, moment.js и сам плагин подключены глобально в layouts/layout --}}
    <script>
        function currency(c) {
            var currencies =  {@foreach(config('currency.currency') as $k => $currency){{ $k }}:"{{ $currency }}"@if (!$loop->last){{ ',' }}@endif @endforeach};
            for (var k in currencies) {
                if(c==k) {
                    return currencies[k];
                }
            }
        }
        const numberRangePicker = {
            rangeInstallation: function (t) {
                var o = $(t.target),
                    e = o.closest('.number_range_picker__body'),
                    i = e.closest('.number_range_picker'),
                    r = e.find('.number_range_picker__item'),
                    s = r.filter('.start_range'),
                    a = r.filter('.end_range');
                if (
                    o.hasClass('number_range_picker__item') ||
                    (o = o.closest('.number_range_picker__item')),
                    0 === s.length
                ) r.removeClass('range_hover'),
                    o.addClass('start_range'),
                    r.on(
                        'mouseover.range_hover',
                        function (t) {
                            r.removeClass('range_hover');
                            var e = $(t.target);
                            e.hasClass('number_range_picker__item') ||
                            (e = e.closest('.number_range_picker__item'));
                            var i = o.index(),
                                s = e.index();
                            if (s < i) {
                                14 < i - s &&
                                (s += i - s - 14);
                                for (var a = i; s <= a; a--) r.eq(a).addClass('range_hover')
                            } else if (i < s) {
                                14 < s - i &&
                                (s -= s - i - 14);
                                for (var n = i + 1; n <= s; n++) r.eq(n).addClass('range_hover')
                            }
                        }
                    );
                else if (0 === a.length) {
                    var n = s.index(),
                        l = o.index(),
                        c = 0,
                        h = 0;
                    if (l < n) {
                        14 < n - l &&
                        (l += n - l - 14);
                        for (var d = n; l < d; d--) r.eq(d).addClass('range_hover');
                        c = r.eq(l).data('val'),
                            h = r.eq(n).data('val')
                    } else if (n < l) {
                        14 < l - n &&
                        (l -= l - n - 14);
                        for (var u = n + 1; u < l; u++) r.eq(u).addClass('range_hover');
                        c = r.eq(n).data('val'),
                            h = r.eq(l).data('val')
                    } else c = h = r.eq(n).data('val');
                    e.closest('.number_range_picker').find('.number_range_picker__input').val(c + ' - ' + h),
                        r.eq(l).addClass('end_range'),
                        i.removeClass('open');
                    var p = i.data();
                    i.find(p.target_from).val(c),
                        i.find(p.target_to).val(h),
                        r.off('mouseover.range_hover')
                } else r.removeClass('start_range end_range range_hover'),
                    numberRangePicker.rangeInstallation(t)
            }
        }

        const childAgeAdd = function () {
            var e,
                i,
                s;
            $('.children').each(
                function () {
                    if (
                        e = $(this).find('.child_age'),
                            i = $(this).find('a.active').text(),
                        e.length > i
                    ) if (0 == i) e.remove();
                    else if (3 === e.length && 2 == i) e.eq(i).remove();
                    else for (var t = s = e.length - i; 0 < t; t--) e.eq(t).remove();
                    else if (e.length < i) {
                        s = i - e.length;
                        for (t = 0; t < s; t++) $(this).append(
                            '<div class="child_age"><button type="button" class="child_age__button child_age__button-minus">-</button><input type="text" readonly value="2 года" class="child_age__input"><button type="button" class="child_age__button child_age__button-plus">+</button></div>'
                        )
                    }
                }
            )
            $('.child_age').each(function(){
                childAge($(this).find('.child_age__button-minus'),parseInt($(this).find('input.child_age__input').val(), 10))
            })
        }

        const childAge = function (t, e) {
            var i = e + ' лет',
                s = t.siblings('input'),
                a = s.closest('.children');
            2 <= e &&
            e <= 4 &&
            (i = e + ' года'),
                s.val(i),
                i = a.find('.quantity.child a.active').text() + ':',
                a.find('input.child_age__input').each(function (t, e) {
                    i += $(e).val() + ','
                }),
                a.children('input').val(i)
        }

        $(document).ready(function () {
            moment.locale('ru');
            $('.js-chosen').chosen({
                width: '100%',
                no_results_text: 'Совпадений не найдено',
                placeholder_text_single: 'Выберите город'
            });
            $('body').on('click', '.s_rating__label', function (event) {
                $('.s_rating__label').removeClass('active');
                $(this).addClass('active');
            });



            let rangeMin = 100;
            const range = document.querySelector(".range-selected");
            const rangeInput = document.querySelectorAll(".range-input input");
            const rangePrice = document.querySelectorAll(".range-price input");

            rangeInput.forEach((input) => {
                input.addEventListener("input", (e) => {
                    let minRange = parseInt(rangeInput[0].value);
                    let maxRange = parseInt(rangeInput[1].value);
                    if (maxRange - minRange < rangeMin) {
                        if (e.target.className === "min") {
                            rangeInput[0].value = maxRange - rangeMin;
                        } else {
                            rangeInput[1].value = minRange + rangeMin;
                        }
                    } else {
                        rangePrice[0].value = minRange;
                        rangePrice[1].value = maxRange;
                        range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
                        range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
                    }
                });
            });

            rangePrice.forEach((input) => {
                input.addEventListener("input", (e) => {
                    let minPrice = rangePrice[0].value;
                    let maxPrice = rangePrice[1].value;
                    if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
                        if (e.target.className === "min") {
                            rangeInput[0].value = minPrice;
                            range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                        } else {
                            rangeInput[1].value = maxPrice;
                            range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                        }
                    }
                });
            });

            /* календарь дат вылета инициализирует единый модуль js/datepicker.js
               (разметка — компонент x-forms.datepicker в s_date.blade.php) */

            $('body').on(
                'click',
                '.number_range_picker input',
                function (e) {
                    e.preventDefault(),
                        $(this).closest('.input_item').toggleClass('open')
                }
            )
            $('body').on(
                'click',
                '.number_range_picker__item',
                numberRangePicker.rangeInstallation
            )

            let child_age,i,s,t;
            $('.children').each(
                function () {
                    if (
                        child_age = $(this).find('.child_age'),
                            i = $(this).find('a.active').text(),
                        child_age.length > i
                    ) if (0 == i) child_age.remove();
                    else if (3 === child_age.length && 2 == i) child_age.eq(i).remove();
                    else for (t = s = child_age.length - i; 0 < t; t--) child_age.eq(t).remove();
                    else if (child_age.length < i) {
                        s = i - child_age.length;
                        for (t = 0; t < s; t++) $(this).append(
                            '<div class="child_age"><button type="button" class="child_age__button child_age__button-minus">-</button><input type="text" readonly value="2 года" class="child_age__input"><button type="button" class="child_age__button child_age__button-plus">+</button></div>'
                        )
                    }
                }
            )
            $('body').on(
                'click',
                '.input_item.dropdown',
                function () {
                    $('.number_people').removeClass('open').children('.number_people_drop').removeClass('open'),
                        $(this).toggleClass('open').children('.form_dropdown').toggleClass('open'),
                        y.customScroll.formDropdown(),
                        $('.input_item.dropdown').not(this).removeClass('open').children('.form_dropdown').removeClass('open')
                }
            ).on(
                'click',
                '.input_item .form_dropdown a',
                function (t) {
                    t.preventDefault();
                    var e = $(this).html(),
                        i = $(this).attr('data-value');
                    $(this).closest('.form_dropdown').siblings('p').html(e),
                    i &&
                    $(this).closest('.form_dropdown').siblings('p').attr('data-value', i)
                }
            )
            $('body').on(
                'click',
                '.input_item.dropdown',
                function () {
                    $(this).toggleClass('open').children('.form_dropdown_comp').toggleClass('open'),
                        $('.input_item.dropdown').not(this).removeClass('open').children('.form_dropdown_comp').removeClass('open')
                }
            )


            $('body').on(
                'click',
                '.number_people',
                function (t) {
                    t.target !== this &&
                    'P' !== t.target.nodeName ||
                    (
                        $(this).toggleClass('open').children('.number_people_drop').toggleClass('open'),
                            $('.number_people').not(this).removeClass('open').children('.number_people_drop').removeClass('open'),
                            $('.input_item.dropdown').removeClass('open').children('.form_dropdown').removeClass('open')
                    )
                }
            )
            $('body').on(
                'click',
                '.full_people .quantity a:not(.active)',
                function (t) {
                    t.preventDefault();
                    var e = 0,
                        i = $(this).closest('.full_people'),
                        s = '';
                    $(this).addClass('active').siblings().removeClass('active');
                    var a = parseInt(i.find('.adult').children('a.active').text());
                    switch (
                        i.find('.child').children('a.active').each(function () {
                            e += parseInt($(this).text())
                        }),
                            !0
                        ) {
                        case 0 === e &&
                        1 < a:
                            s = a + ' взрослых';
                            break;
                        case 0 === e &&
                        1 === a:
                            s = a + ' взрослый';
                            break;
                        default:
                            s = a + ' взр. ' + e + ' реб.'
                    }
                    return i.siblings('p').text(s),
                        e
                }
            ),
                $('.only_child .quantity').on(
                    'click',
                    'a',
                    function (t) {
                        t.preventDefault();
                        var e = 0,
                            i = $(this).closest('.only_child');
                        return $(this).addClass('active').siblings().removeClass('active'),
                            i.find('.quantity').children('a.active').each(function () {
                                e += parseInt($(this).text())
                            }),
                            i.siblings('p').text(0 === e ? 'Не выбрано' : e + ' реб.'),
                            e
                    }
                ),
                $('body').on(
                    'click',
                    '.children .quantity a:not(.active)',
                    function (t) {
                        childAgeAdd()
                    }
                )
            $('body').on(
                'click',
                '.quantity.child a:not(.active)',
                function (t) {
                    var e = $(t.target).closest('.how_people'),
                        i = 0,
                        s = 0;
                    e.hasClass('children') ? (
                        i = Number($(t.target).text()),
                            s = Number($('#infatn_list').find('.active').text())
                    ) : (
                        s = Number($(t.target).text()),
                            i = Number($('#child_list').find('.active').text())
                    ),
                        $('#infatn_list').find('a').each(
                            function () {
                                3 < Number($(this).text()) + i ? $(this).addClass('disable') : $(this).removeClass('disable')
                            }
                        ),
                        $('#child_list').find('a').each(
                            function () {
                                3 < Number($(this).text()) + s ? $(this).addClass('disable') : $(this).removeClass('disable')
                            }
                        )
                }
            )
            $('body').on(
                'click',
                '.quantity a',
                function () {
                    var t = $(this).data('input'),
                        e = $(this).html();
                    void 0 !== t &&
                    $('#' + t).val(e)
                }
            )
            $('body').on(
                'click',
                '.child_age__button-minus',
                function () {
                    var t = $(this).siblings('input'),
                        e = parseInt(t.val(), 10);
                    return 2 < e &&
                    (e--, childAge($(this), e)),
                        !1
                }
            ).on(
                'click',
                '.child_age__button-plus',
                function () {
                    var t = $(this).siblings('input'),
                        e = parseInt(t.val(), 10);
                    return e < 14 &&
                    (e++, childAge($(this), e)),
                        !1
                }
            )
            childAgeAdd()

        });
    </script>
@endsection
