<?php
// временный диагностический скрипт — удалить после проверки
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$rows = Illuminate\Support\Facades\DB::select('SHOW TABLE STATUS');
$out = [];
foreach ($rows as $r) {
    $r = (array) $r;
    $out[] = [$r['Name'], (int) $r['Rows']];
}
usort($out, fn($a, $b) => $b[1] <=> $a[1]);
foreach ($out as $o) {
    if ($o[1] > 0) {
        printf("%-42s %d\n", $o[0], $o[1]);
    }
}
printf("--- всего таблиц: %d ---\n", count($rows));
