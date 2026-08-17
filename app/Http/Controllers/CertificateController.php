<?php

namespace App\Http\Controllers;

use App\Enums\Pages\ListTemplate;
use Domain\Certificate\ViewModels\CertificateViewModel;

class CertificateController extends Controller
{
    public function page()
    {
        /**
         * Страница «Сертификаты» (/sertifikaty)
         *
         * Своей модели у страницы нет: заголовок, описание и метатеги
         * приходят из настроек (админка: «Категории» → «Сертификаты»).
         **/

        $page = CertificateViewModel::make()->getPageData();

        return view('pages.certificates.certificates', [
            'page' => $page,
            // шаблон содержимого — pages/certificates/templates/list/*.blade.php,
            // см. App\Enums\Pages\ListTemplate. Пока в настройках ничего не выбрано,
            // раздел рисуется своим шаблоном «Сертификаты», а не стандартным
            'template' => ListTemplate::fromValue($page->list_template ?: ListTemplate::Certificates->value),
        ]);
    }
}
