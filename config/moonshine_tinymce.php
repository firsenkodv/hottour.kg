<?php

return [
    'token' => env('TINYMCE_TOKEN', ''),
    // Набор плагинов повторяет v2 (App\MoonShine\Fields\TinyMce).
    // 'autoresize' убран намеренно: в v2 его не было, а высота задана жёстко в options.
    'plugins' => [
        'anchor', 'autolink', 'charmap', 'codesample', 'code', 'emoticons', 'image', 'link',
        'lists', 'advlist', 'media', 'searchreplace', 'table', 'wordcount', 'directionality',
        'fullscreen', 'help', 'nonbreaking', 'pagebreak', 'preview', 'visualblocks', 'visualchars'
    ],
    'menubar' => 'file edit insert view format table tools',
    'toolbar' => 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | '
        . 'link image media table tabledelete hr nonbreaking pagebreak | align lineheight | '
        . 'numlist bullist indent outdent | emoticons charmap | removeformat | codesample | ltr rtl | '
        . 'tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | '
        . 'tableinsertcolbefore tableinsertcolafter tabledeletecol | '
        . 'fullscreen preview print visualblocks visualchars code | help',
    // v2: public array $config = ['height' => 500, 'resize' => true];
    'options' => [
        'height' => 500,
        'resize' => true,
    ],
    'callbacks' => [],
];
