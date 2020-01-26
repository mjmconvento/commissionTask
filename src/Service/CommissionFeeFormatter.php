<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Interfaces\FormatterInterface;

class CommissionFeeFormatter implements FormatterInterface
{
    /**
     * @param float $value
     *
     * @return string
     */
    public function format(float $value): string
    {
        $pow = pow(10, 2);
        $total = (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;

        return number_format($total, 2, '.', '');
    }
}
