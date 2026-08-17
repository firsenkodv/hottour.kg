{{-- Загрузчик API Яндекс.Карт. Отключается флагом yandex_maps,
     см. config/external.php (api-maps.yandex.ru недоступен из-под VPN). --}}
@external('yandex_maps')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=43db27ba-be61-4e84-b139-ff37ad4802b8&lang=ru_RU" type="text/javascript"></script>
@else
    <x-external.disabled service="Яндекс.Карты"/>
@endexternal
