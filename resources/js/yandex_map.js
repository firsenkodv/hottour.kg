setTimeout(function () {

    // api-maps.yandex.ru недоступен из-под VPN и висит до таймаута,
    // флаг приходит из config/external.php через window.EXTERNAL
    if (window.EXTERNAL && window.EXTERNAL.yandex_maps === false) {
        return;
    }

   // elem.src = '//api-maps.yandex.ru/2.1/?apikey=43db27ba-be61-4e84-b139-ff37ad4802b8&package.standard&lang=ru_RU&onload=getYaMap';
    if($('#JFormFieldMap').length) {
        var elem = document.createElement('script');
        elem.type = 'text/javascript';
        elem.src = '//api-maps.yandex.ru/2.1/?apikey=43db27ba-be61-4e84-b139-ff37ad4802b8&package.standard&lang=ru_RU&onload=getYaMap';
        document.getElementsByTagName('body')[0].appendChild(elem);

        if($('#loader_wrapper').length) {
            document.getElementById('loader_wrapper').style.visibility = 'hidden';
        }
        if($('.wrapper_loader').length) {
            document.querySelector(".wrapper_loader").style.display = 'none';
        }
    }


}, 2000);






