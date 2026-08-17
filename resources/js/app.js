import './bootstrap';
import {Fancybox} from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import './fancybox';
// IMask to add input masks support
import IMask from 'imask';
window.IMask = IMask;

// core version + navigation, pagination modules:
import Swiper from 'swiper';
import {Navigation, Pagination, Controller} from 'swiper/modules';
Swiper.use([Navigation, Pagination, Controller]);



import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';


import './swiper';
import './translate/translate';
import './chosen/chosen.jquery';

//import 'slick-carousel/slick/slick';


import './imask';
import './select';
import './ajax';
import './yandex_map';
import './calc/calc';
import './checkbox';
import './cart';
import './script';
import './datepicker';
import './certificates';
import './mobile';
