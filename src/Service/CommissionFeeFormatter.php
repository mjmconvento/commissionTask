<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Service;

use Paysera\CommissionTask\Interfaces\FormatterInterface;

class CommissionFeeFormatter implements FormatterInterface
{
    public function format(float $value): string
    {
        $pow = pow(10, 2);
        $total = (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;

        return number_format($total, 2, '.', '');
    }
}
