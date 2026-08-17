<?php

namespace App\Bitrix24;

use Support\Traits\Makeable;
use Throwable;

/**
 * Заявка с сайта → контакт + сделка в Битрикс24.
 *
 * Вызывается из App\Listeners\Bitrix24HandlerListener параллельно с письмом:
 * ошибка интеграции не должна ломать отправку заявки на почту, поэтому все
 * методы гасят исключения и возвращают false.
 */
class SaveLead extends Bitrix24
{
    use Makeable;

    /**
     * @param array{title: string, name?: string, phone?: string, email?: string, url?: string, fields?: array<string, mixed>} $data
     */
    public function save(array $data): bool
    {
        if (!$this->isReady()) {
            return false;
        }

        $contactId = $this->saveContact($data);

        if ($contactId === false) {
            return false;
        }

        return $this->saveDeal($data, $contactId) !== false;
    }

    /**
     * Контакт ищется по телефону, затем по email — чтобы постоянный клиент
     * не плодил дубли при каждой заявке.
     */
    public function saveContact(array $data): int|false
    {
        try {
            $contactId = null;
            $phone = $data['phone'] ?? null;
            $email = $data['email'] ?? null;

            if ($phone) {
                $found = $this->result('crm.contact.list', [
                    'filter' => ['PHONE' => $phone],
                    'select' => ['ID'],
                    'start' => 0,
                ]);

                if (!empty($found)) {
                    $contactId = (int) $found[0]['ID'];
                }
            }

            if (!$contactId && $email) {
                $found = $this->result('crm.contact.list', [
                    'filter' => ['EMAIL' => $email],
                    'select' => ['ID'],
                    'start' => 0,
                ]);

                if (!empty($found)) {
                    $contactId = (int) $found[0]['ID'];
                }
            }

            if (!$contactId) {
                $fields = [
                    'NAME' => $data['name'] ?: 'Без имени',
                    'ASSIGNED_BY_ID' => $this->responsibleId,
                    'SOURCE_ID' => 'WEB',
                ];

                if ($phone) {
                    $fields['PHONE'] = [['VALUE' => $phone, 'VALUE_TYPE' => 'WORK']];
                }

                if ($email) {
                    $fields['EMAIL'] = [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']];
                }

                $contactId = (int) $this->result('crm.contact.add', ['fields' => $fields]);
            }

            return $contactId;

        } catch (Throwable $e) {
            $this->log('saveContact — ' . $e->getMessage(), ['data' => $data]);

            return false;
        }
    }

    public function saveDeal(array $data, int|null $contactId = null): int|false
    {
        try {
            $title = $data['title'] . ' — ' . ($data['name'] ?: ($data['phone'] ?? 'без контактов'));

            $comments = [];

            foreach ($data['fields'] ?? [] as $label => $value) {
                if ($value !== null && $value !== '') {
                    $comments[] = $label . ': ' . $value;
                }
            }

            if (!empty($data['url'])) {
                $comments[] = 'Страница: ' . $data['url'];
            }

            $fields = [
                'TITLE' => $title,
                'STAGE_ID' => 'NEW',
                'SOURCE_ID' => 'WEB',
                'ASSIGNED_BY_ID' => $this->responsibleId,
                'COMMENTS' => implode("\n", $comments),
            ];

            if ($contactId) {
                $fields['CONTACT_ID'] = $contactId;
            }

            if (!empty($data['opportunity'])) {
                $fields['OPPORTUNITY'] = (float) $data['opportunity'];
            }

            return (int) $this->result('crm.deal.add', ['fields' => $fields]);

        } catch (Throwable $e) {
            $this->log('saveDeal — ' . $e->getMessage(), ['data' => $data]);

            return false;
        }
    }
}
