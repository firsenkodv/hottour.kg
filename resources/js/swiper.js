// init Swiper:
import Swiper from "swiper";
import {Navigation, Pagination} from "swiper/modules";

new Swiper('.mainswiper', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination],
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

/*
new Swiper('.swiper_hottours', {

    modules: [Navigation, Pagination],
    spaceBetween: 30,

    loop: true,
    slidesPerView: "auto",


    navigation: {
        nextEl: ".swiper-button-next-swiper_hottours",
        prevEl: ".swiper-button-prev-swiper_hottours",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        666: {
            slidesPerView: "auto",
        },
        742: {
            slidesPerView: "auto",
        },
        991: {
            slidesPerView: 3,
            spaceBetween: 20,

        },
        1200: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 20,

        },
        1600: {
            slidesPerView: 5
        }
    }
});
*/


var swiper_test = new Swiper(".mySwiper", {
    loop: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    spaceBetween: 30,
    grabCursor: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});





/*
new Swiper('.swiper_populars', {
    modules: [Navigation, Pagination],
    slidesPerView: 4,
    spaceBetween: 30,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next-swiper_populars",
        prevEl: ".swiper-button-prev-swiper_populars",
    },
    breakpoints: {
        320: {
            slidesPerView: 1
        },
        568: {
            slidesPerView: 2
        },
        742: {
            slidesPerView: 3
        },
        991: {
            slidesPerView: 4,
            loop: true,

        }
    }
});
*/





// init swiper_researches:
new Swiper('.swiper_responce', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination],
    slidesPerView: "auto",
    spaceBetween: 30,
    slidesPerGroup: 3,
    // rewind вместо loop: loop в swiper 10 молча отключается при
    // slidesPerView: "auto" + slidesPerGroup 3 с некратным числом слайдов
    rewind: true,
    navigation: {
        nextEl: ".swiper-button-next-swiper_responce",
        prevEl: ".swiper-button-prev-swiper_responce",
    },
    breakpoints: {
        // mobile + tablet - 320-990
        320: {
            slidesPerView: 1,
            slidesPerGroup: 1,
        },
        568: {
            slidesPerView: 2,
            slidesPerGroup: 1,
        },
        742: {
            slidesPerView: 3,
            slidesPerGroup: 2,
        },
        // desktop >= 991
        991: {
            slidesPerView: "auto",

        }
    }
});


//
new Swiper('.swiper_banner', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination],
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next-swiper_banner",
        prevEl: ".swiper-button-prev-swiper_banner",
    },
    breakpoints: {
        // mobile + tablet - 320-990
        320: {
            slidesPerView: 1
        },
        568: {
            slidesPerView: 1
        },
        742: {
            slidesPerView: 1,

        },
        // desktop >= 991
        991: {

            slidesPerView: 1,
            loop: true,

        }
    }
});


$(document).ready(function() {

    /* gallery hotel */
    var galleryTop = new Swiper('.gallery-top', {
        modules: [Navigation, Pagination],
      //  loopedSlides: 50,

        loop: true,
        initialSlide: 0, //this one accept a number according to docs
        slidesPerView: 1, //number or 'auto'
        slidesPerColumn: 1, //number

        navigation: {
            nextEl: '.swiper-button-next-swiper_banner',
            prevEl: '.swiper-button-prev-swiper_banner',
        },
    });
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        modules: [Navigation, Pagination],
        direction: 'vertical',
        loop: true,
        initialSlide: 0, //this one accept a number according to docs
        slidesPerView: 4,
        slidesPerColumn: 1, //number

         slideToClickedSlide: true,
        spaceBetween: 10,
       // loopedSlides: 50,
    });
    galleryTop.controller.control = galleryThumbs;
    galleryThumbs.controller.control = galleryTop;
});
