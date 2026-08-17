<?php

namespace App\View\Composers;



use App\ChangeContacts\ContactRotator;
use App\Models\MoonshineSetting;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class ChangeContactComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {
        // Композер навешан сразу на несколько шаблонов и отрабатывает
        // по одному разу на каждый @include — без мемоизации это давало
        // по 9 одинаковых запросов к change_load_contacts и moonshine_settings.
        $contacts = $this->contacts();

        $view->with([
            'phone' => $contacts['phone'],
            'whatsapp' => $contacts['whatsapp'],
            'telegram' => $contacts['telegram'],
        ]);
    }

    /**
     * @return array{phone: mixed, whatsapp: mixed, telegram: mixed}
     */
    private function contacts(): array
    {
        return $this->cache(function (): array {
            $first = ContactRotator::state();               // основные
            $second = MoonshineSetting::query()->first();   // дополнительные, если выключены основные

            return [
                'phone' => $first?->phone ?? $second?->phone1,
                'whatsapp' => $first?->whatsapp ?? $second?->whatsapp,
                'telegram' => $first?->telegram ?? $second?->telegram,
            ];
        });
    }
}
