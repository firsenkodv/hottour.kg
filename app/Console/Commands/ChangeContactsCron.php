<?php

namespace App\Console\Commands;

use App\ChangeContacts\ContactRotator;
use Illuminate\Console\Command;

class ChangeContactsCron extends Command
{
    /**
     * Тестовый запуск php artisan change-contacts:cron
     *
     * @var string
     */
    protected $signature = 'change-contacts:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start cron - change-contacts:cron';

    /**
     * Ежедневная смена контактов для каналов в режиме 2.
     * Расписание — App\Console\Kernel: dailyAt('00:00').
     */
    public function handle(): int
    {
        foreach (ContactRotator::CHANNELS as $channel) {
            $changed = ContactRotator::rotate($channel, ContactRotator::MODE_DAILY);

            $this->line($changed
                ? $channel . ' — сменили'
                : $channel . ' — без изменений');
        }

        return self::SUCCESS;
    }
}
