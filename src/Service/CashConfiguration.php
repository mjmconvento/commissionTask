<?php

declare(strict_types=1);

namespace CommissionTask\Service;

class CashConfiguration
{
    /**
     * @var float CASHOUT_COMMISSION_MULTIPLIER
     */
    public const CASHOUT_COMMISSION_MULTIPLIER = .003;

    /**
     * @var float CASHOUT_MINIMUM_VALUE
     */
    public const CASHOUT_MINIMUM_VALUE = .5;

    /**
     * @var float CASHIN_COMMISSION_MULTIPLIER
     */
    public const CASHIN_COMMISSION_MULTIPLIER = .0003;

    /**
     * @var int CASHIN_MAXIMUM_VALUE
     */
    public const CASHIN_MAXIMUM_VALUE = 5;

    /**
     * @var string NATURAL
     */
    public const NATURAL = 'natural';

    /**
     * @var string LEGAL
     */
    public const LEGAL = 'legal';

    /**
     * @var string CASH_IN
     */
    public const CASH_IN = 'cash_in';

    /**
     * @var string CASH_OUT
     */
    public const CASH_OUT = 'cash_out';
}
