<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Interfaces;

interface FormatterInterface
{
    public function format(float $value);
}
