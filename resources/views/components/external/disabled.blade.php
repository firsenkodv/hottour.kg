{{-- Плашка на месте отключённого стороннего блока (карта, виджет).
     Показывается, когда сервис выключен в config/external.php — обычно
     на локальной машине под VPN.

     Стили инлайном осознанно: блок нужен только в dev-режиме, из-за него
     не стоит держать правила в app.css и пересобирать vite. --}}
@props(['service' => 'Внешний сервис'])

<div {{ $attributes->merge(['class' => 'external-disabled']) }}
     style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;min-height:180px;padding:24px;border:1px dashed #c7c7c7;border-radius:12px;background:#f5f5f5;color:#8a8a8a;font-size:14px;text-align:center;">
    <span style="font-weight:600;color:#6b6b6b;">{{ $service }} — отключён</span>
    <span style="font-size:12px;">Локальная среда, EXTERNAL_SERVICES=false</span>
</div>
