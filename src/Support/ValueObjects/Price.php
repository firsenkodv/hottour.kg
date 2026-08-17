<?php

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

class Price implements Stringable
{

    use Makeable;

    private array $currencies = [
        'RUB' => '₽',
        'KZT' => '₸'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'KZT',
        private readonly int $precision  = 1,
    )
    {
        if($value < 0) {
            throw new InvalidArgumentException(__("Цена должна быть больше 0"));
        }
        if(!isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException(__("Валюта не поддерживается"));
        }

    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency():string
    {
        return $this->currency;
    }

    public function symbol():string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString()
    {
        return number_format($this->value(), 0, '.', ' '). ' ' . $this->symbol();

    }
}
