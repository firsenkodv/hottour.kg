//todo:jquery

// работает без атрибута модели user format_sex и format_nationality
// если настроены атрибуты и функции helpers, то не нужно "проходить" по всем select-там
$('.select').each(function (index) {

    $(this).find('.select__item').each(function (index) {
        let option = $(this).data('option');
        let text = $(this).text();
        let selectHead  = $(this).parents('.select').find('.select__head');
        if(option === selectHead.text()) {
            selectHead.text(text);
        }
      //  console.log(option);
    });
});


var thisSelect = $('.select__head').parents('.select');
var thisValue = thisSelect.find('.select__input').val();

$(thisSelect.find('.select__item')).each(function (index) {
    if ($(this).text() == thisValue) {
        $(this).addClass('active');
    }
});

jQuery(($) => {
    $('.select').on("click", ".select__head", function () {


        if ($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(this).next().fadeOut();
        } else {

            $(".select__head").removeClass("open");
            $(".select__list").fadeOut();
            $(this).addClass("open");
            $(this).next().fadeIn();
        }
    });

    $('.select').on("click", ".select__item", function () {


        $(".select__head").removeClass("open");
        $(this).parent().fadeOut();

        $(this).parent().prev().text($(this).text());

        $(this).parent().prev().prev().val($(this).data('option'));


        let parents = $(this).parent('.select__list');
        parents.find('.select__item').removeClass('active');
        $(this).addClass('active');
    });

    $(document).click(function (e) {
        if (!$(e.target).closest(".select").length) {
            $(".select__head").removeClass("open");
            $(".select__list").fadeOut();
        }
    });


});


// $('.new-select').text(selectActive);


