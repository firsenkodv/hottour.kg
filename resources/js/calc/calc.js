setTimeout(function () {

    // elem.src = '//api-maps.yandex.ru/2.1/?apikey=43db27ba-be61-4e84-b139-ff37ad4802b8&package.standard&lang=ru_RU&onload=getYaMap';
    if($('.selectBox').length) {
        var selectbox = document.createElement('script');
        selectbox.type = 'text/javascript';
        selectbox.src = '/js/selectbox/selectbox.js';
        var calc = document.createElement('script');
        calc.type = 'text/javascript';
        calc.src = '/js/selectbox/calc.js';
 /*       var style = document.createElement('link');
        style.rel = 'stylesheet';
        style.type = 'text/css';
        style.href = '/css/selectbox/selectbox.css'; // ВЫВОДИМ СРАЗУ !!!*/
        document.getElementsByTagName('body')[0].appendChild(selectbox);
        document.getElementsByTagName('body')[0].appendChild(calc);
    /*    document.getElementsByTagName('body')[0].appendChild(style);*/

        if($('#loader_wrapper').length) {
            document.getElementById('loader_wrapper').style.visibility = 'hidden';
        }
        if($('.wrapper_loader').length) {
            document.querySelector(".wrapper_loader").style.display = 'none';
        }

    }

}, 1100);

