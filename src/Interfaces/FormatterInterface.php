<?php

declare(strict_types=1);

namespace CommissionTask\Interfaces;

interface FormatterInterface
{
    public function format(float $value);
}
