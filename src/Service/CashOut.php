<?php

declare(strict_types=1);

namespace CommissionTask\Service;

class CashOut
{
    public function getCommission(int $key, array $value): float
    {
        $type = $value[2];
        $amount = $value[4];

        if (!is_numeric($amount)) {
            throw new \Exception(sprintf('Invalid amount on line %s', $key + 1));
        }

        if ($type !== CashConfiguration::NATURAL && $type !== CashConfiguration::LEGAL) {
            throw new \Exception(sprintf('Invalid user type on line %s', $key + 1));
        }

        $total = $amount * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER;

        if ($type === CashConfiguration::NATURAL) {
            return $total;
        } elseif ($type === CashConfiguration::LEGAL) {
            return $total <= CashConfiguration::CASHOUT_MINIMUM_VALUE ? CashConfiguration::CASHOUT_MINIMUM_VALUE : $total;
        }
    }
}
