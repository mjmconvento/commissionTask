<?php

declare(strict_types=1);

namespace CommissionTask\Service;

class CashOut
{
    /**
     * @var string NATURAL
     */
    private const NATURAL = 'natural';

    /**
     * @var string LEGAL
     */
    private const LEGAL = 'legal';

    /**
     * @var float COMMISSION_MULTIPLIER
     */
    private const COMMISSION_MULTIPLIER = .003;

    /**
     * @var float MINIMUM_VALUE
     */
    private const MINIMUM_VALUE = .5;

    public function getCommission(int $key, array $value): float
    {
        $type = $value[2];
        $amount = $value[4];

        if (!is_numeric($amount)) {
            throw new \Exception(sprintf('Invalid amount on line %s', $key + 1));
        }

        if ($type !== self::NATURAL && $type !== self::LEGAL) {
            throw new \Exception(sprintf('Invalid user type on line %s', $key + 1));
        }

        if ($type === self::NATURAL) {
            return $amount * self::COMMISSION_MULTIPLIER;
        } elseif ($type === self::LEGAL) {
            $total = $amount * self::COMMISSION_MULTIPLIER;

            return $total <= self::MINIMUM_VALUE ? self::MINIMUM_VALUE : $total;
        }
    }
}
