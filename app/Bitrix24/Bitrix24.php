<?php

namespace App\Bitrix24;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Транспорт до Битрикс24 через входящий вебхук.
 *
 * Доступы редактируются в админке: «Настройки сайта» → вкладка «Битрикс24»
 * (App\MoonShine\Pages\MoonshineSettingPage), лежат группой `bitrix24`
 * в таблице settings.
 */
class Bitrix24
{
    public const GROUP = 'bitrix24';

    protected string $webhook;
    protected mixed $responsibleId;
    protected bool $enabled;

    public function __construct()
    {
        $setting = Setting::getGroup(self::GROUP);

        $this->webhook = (string) $setting->getValue('bx_webhook', '');
        $this->responsibleId = $setting->getValue('bx_resp_id');
        $this->enabled = (bool) $setting->getValue('bx_enabled', false);
    }

    /**
     * Интеграция выключена или заполнена не полностью — заявка просто уходит
     * на почту, как и раньше. Без адреса портала запрос отправлять некуда,
     * без ID ответственного сделка повиснет ни на кого, поэтому оба поля
     * обязательны.
     */
    public function isReady(): bool
    {
        // external('crm') — общий флаг внешних интеграций (config/external.php):
        // на локальной машине заявки не должны улетать в боевой портал
        return external('crm')
            && $this->enabled
            && $this->webhook !== ''
            && $this->responsibleId !== null
            && trim((string) $this->responsibleId) !== '';
    }

    public function call(string $method, array $data = []): array
    {
        $url = rtrim($this->webhook, '/') . '/' . $method . '.json';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno) {
            throw new RuntimeException('cURL error: ' . $error);
        }

        $json = json_decode($response, true);

        if ($json === null) {
            throw new RuntimeException('Некорректный JSON в ответе Битрикс24');
        }

        if (!empty($json['error'])) {
            throw new RuntimeException($json['error_description'] ?? $json['error']);
        }

        return $json;
    }

    public function result(string $method, array $data = []): mixed
    {
        return $this->call($method, $data)['result'] ?? [];
    }

    protected function log(string $message, array $context = []): void
    {
        Log::error('Bitrix24: ' . $message, $context);
    }
}
