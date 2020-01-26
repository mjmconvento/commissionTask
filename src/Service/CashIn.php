<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Service;

class CashIn
{
    /**
     * @var float COMMISSION_MULTIPLIER
     */
    private const COMMISSION_MULTIPLIER = .0003;

    /**
     * @var int MAXIMUM_VALUE
     */
    private const MAXIMUM_VALUE = 5;

    public function getCommission(int $key, array $value): float
    {
        if (!is_numeric($value[4])) {
            throw new \Exception(sprintf('Invalid value on line %s', $key + 1));
        }

        $total = $value[4] * self::COMMISSION_MULTIPLIER;

        return $total >= self::MAXIMUM_VALUE ? self::MAXIMUM_VALUE : $total;
    }
}
