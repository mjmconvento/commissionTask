<?php

declare(strict_types=1);

namespace CommissionTask\Tests\Service;

use CommissionTask\Service\CashConfiguration;
use CommissionTask\Service\CommissionFeeFormatter;
use CommissionTask\Service\CommissionFeeProcessor;
use PHPUnit\Framework\TestCase;

class CommissionFeeProcessorTest extends TestCase
{
    /**
     * @var CommissionFeeProcessor
     */
    private $commissionFeeProcessor;

    public function setUp()
    {
        $this->commissionFeeProcessor = new CommissionFeeProcessor(
            new CommissionFeeFormatter
        );
    }

    /**
     * @param array $value
     * @param string $expectation
     *
     * @dataProvider dataProviderForProcessTesting
     */
    public function testFormat(array $value, array $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->commissionFeeProcessor->process($value)
        );
    }

    /**
     * @return array
     */
    public function dataProviderForProcessTesting(): array
    {
        $valueIndexZero = 1200.00;
        $valueIndexOne = 1000.00;
        $valueIndexTwo = 1000.00;
        $valueIndexThree = 200.00;
        $valueIndexFour = 300.00;
        $valueIndexFive = 1000.00;
        $valueIndexSix = 100.00;
        $valueIndexSeven = 1000000.00;
        $valueIndexEight = 1000.00;
        $valueIndexNine = 300.00;
        $valueIndexTen = 100.00;
        $valueIndexEleven = 3000000;

        return [
            'test array of commission fee processor' => [
                [
                    [
                        '2014-12-31',
                        4,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexZero,
                        'EUR'
                    ], 
                    [
                        '2015-01-01',
                        4,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexOne,
                        'EUR'
                    ],
                    [
                        '2016-01-05',
                        4,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexTwo,
                        'EUR'
                    ],
                    [
                        '2016-01-05',
                        1,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_IN,
                        $valueIndexThree,
                        'EUR'
                    ],
                    [
                        '2016-01-06',
                        2,
                        CashConfiguration::LEGAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexFour,
                        'EUR'
                    ],
                    [
                        '2016-01-07',
                        1,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexFive,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        1,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexSix,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        2,
                        'legal',
                        CashConfiguration::CASH_IN,
                        $valueIndexSeven,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        3,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexEight,
                        'EUR'
                    ],
                    [
                        '2016-02-15',
                        1,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexNine,
                        'EUR'
                    ],
                    [
                        '2016-01-07',
                        1,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexTen,
                        'USD'
                    ],
                    [
                        '2016-02-19',
                        5,
                        CashConfiguration::NATURAL,
                        CashConfiguration::CASH_OUT,
                        $valueIndexEleven,
                        'JPY'
                    ]
                ],
                [
                    $valueIndexZero * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexOne * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexTwo * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexThree * CashConfiguration::CASHIN_COMMISSION_MULTIPLIER,
                    $valueIndexFour * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexFive * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexSix * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    CashConfiguration::CASHIN_MAXIMUM_VALUE,
                    $valueIndexEight * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexNine * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexTen * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER,
                    $valueIndexEleven * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER
                ]
            ]
        ];
    }

    /**
     * @param array $value
     * @param string $expectation
     *
     * @dataProvider dataProviderForExceptionTesting
     */
    public function testException(array $value, string $expectation)
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($expectation);
        $this->commissionFeeProcessor->process($value);
    }

    /**
     * @return array
     */
    public function dataProviderForExceptionTesting(): array
    {
        return [
            'test exception for commission fee processor invalid csv format' => [
                [
                    []
                ],
                'Invalid csv format'
            ],
            'test exception for commission fee processor invalid operation type' => [
                [
                    [
                        3 => 'invalid operation type'
                    ]
                ],
                'Invalid operation type on line 1'
            ]
        ];
    }
}
