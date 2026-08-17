<?php

/**
 * Разовый скрипт: выносит base64-картинки из blade-шаблонов в файлы.
 *
 * Что делает:
 *  - обходит resources/views/**\/*.blade.php;
 *  - находит вставки data:image/...;base64,...;
 *  - декодирует и сохраняет в public/images/inline/ (одинаковые картинки — один файл);
 *  - заменяет вставку на {{ asset('images/inline/<файл>') }}.
 *
 * Запуск:  php scripts/extract_inline_images.php [--dry]
 */

$root = dirname(__DIR__);
$viewsDir = $root . '/resources/views';
$publicSubdir = 'images/inline';
$outDir = $root . '/public/' . $publicSubdir;

$dryRun = in_array('--dry', $argv, true);

$extByMime = [
    'svg+xml' => 'svg',
    'png' => 'png',
    'jpeg' => 'jpg',
    'jpg' => 'jpg',
    'gif' => 'gif',
    'webp' => 'webp',
];

if (! $dryRun && ! is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

/** @var array<string, string> хеш содержимого => имя файла */
$saved = [];
$stats = ['files' => 0, 'images' => 0, 'reused' => 0, 'bytes_removed' => 0, 'bytes_written' => 0];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));

foreach ($iterator as $file) {
    if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.php')) {
        continue;
    }

    $path = $file->getPathname();
    $original = file_get_contents($path);

    if (! str_contains($original, 'data:image/')) {
        continue;
    }

    // Базовое имя для картинок этого шаблона: путь относительно views через дефис
    $relative = str_replace('\\', '/', substr($path, strlen($viewsDir) + 1));
    $base = preg_replace('~\.blade\.php$|\.php$~', '', $relative);
    $base = strtolower(preg_replace('~[^a-zA-Z0-9]+~', '-', $base));
    $base = trim($base, '-');

    $index = 0;
    $content = $original;

    $replace = function (array $m) use (&$index, &$saved, &$stats, $base, $extByMime, $outDir, $publicSubdir, $dryRun): string {
        $mime = strtolower($m['mime']);
        $data = preg_replace('~\s+~', '', $m['data']);
        $binary = base64_decode($data, true);

        if ($binary === false || $binary === '') {
            return $m[0]; // не трогаем то, что не декодировалось
        }

        $hash = sha1($binary);
        $stats['images']++;
        $stats['bytes_removed'] += strlen($m[0]);

        if (isset($saved[$hash])) {
            $stats['reused']++;
            $name = $saved[$hash];
        } else {
            $ext = $extByMime[$mime] ?? 'bin';
            $index++;
            $name = $base . '-' . $index . '.' . $ext;

            if (! $dryRun) {
                file_put_contents($outDir . '/' . $name, $binary);
            }

            $saved[$hash] = $name;
            $stats['bytes_written'] += strlen($binary);
        }

        return "{{ asset('" . $publicSubdir . '/' . $name . "') }}";
    };

    // 1) {!! 'data:...' !!} — вставка через вывод строки
    $content = preg_replace_callback(
        '~\{!!\s*\'data:image/(?<mime>[a-z+]+);base64,(?<data>[A-Za-z0-9+/=\s]+)\'\s*!!\}~',
        $replace,
        $content
    );

    // 2) "data:..." и 'data:...' — src, xlink:href, background-image: url()
    $content = preg_replace_callback(
        '~data:image/(?<mime>[a-z+]+);base64,(?<data>[A-Za-z0-9+/=\s]+?)(?=["\'\)])~',
        $replace,
        $content
    );

    if ($content !== $original) {
        $stats['files']++;

        if (! $dryRun) {
            file_put_contents($path, $content);
        }

        printf(
            "%-62s %s%s",
            $relative,
            number_format((strlen($original) - strlen($content)) / 1024, 1) . ' KB',
            PHP_EOL
        );
    }
}

echo PHP_EOL;
echo 'Режим:            ', $dryRun ? 'DRY RUN (файлы не менялись)' : 'запись', PHP_EOL;
echo 'Шаблонов изменено:', ' ', $stats['files'], PHP_EOL;
echo 'Картинок найдено: ', ' ', $stats['images'], ' (из них дублей: ', $stats['reused'], ')', PHP_EOL;
echo 'Файлов создано:   ', ' ', count($saved), PHP_EOL;
echo 'Убрано из шаблонов:', ' ', number_format($stats['bytes_removed'] / 1024, 1), ' KB', PHP_EOL;
echo 'Записано в файлы: ', ' ', number_format($stats['bytes_written'] / 1024, 1), ' KB', PHP_EOL;
