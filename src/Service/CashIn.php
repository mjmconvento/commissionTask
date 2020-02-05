<?php

declare(strict_types=1);

namespace CommissionTask\Service;

class CashIn
{
    public function getCommission(int $key, array $value): float
    {
        if (!is_numeric($value[4])) {
            throw new \Exception(sprintf('Invalid value on line %s', $key + 1));
        }

        $total = $value[4] * CashConfiguration::CASHIN_COMMISSION_MULTIPLIER;

        return $total >= CashConfiguration::CASHIN_MAXIMUM_VALUE ? CashConfiguration::CASHIN_MAXIMUM_VALUE : $total;
    }
}
