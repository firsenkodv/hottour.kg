<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use MoonShine\UI\Fields\Field;

/**
 * Справка о режимах показа средств связи.
 * Данных не хранит — только статичный blade-блок.
 *
 * v2: App\MoonShine\Fields\Node.
 */
class Node extends Field
{
    protected string $view = 'admin.fields.node';
}
