<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Tests\Service;

use Paysera\CommissionTask\Service\CommissionFeeFormatter;
use Paysera\CommissionTask\Service\CommissionFeeProcessor;
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
        return [
            'test array of commission fee processor' => [
                [
                    [
                        '2014-12-31',
                        4,
                        'natural',
                        'cash_out',
                        1200.00,
                        'EUR'
                    ], 
                    [
                        '2015-01-01',
                        4,
                        'natural',
                        'cash_out',
                        1000.00,
                        'EUR'
                    ],
                    [
                        '2016-01-05',
                        4,
                        'natural',
                        'cash_out',
                        1000.00,
                        'EUR'
                    ],
                    [
                        '2016-01-05',
                        1,
                        'natural',
                        'cash_in',
                        200.00,
                        'EUR'
                    ],
                    [
                        '2016-01-06',
                        2,
                        'legal',
                        'cash_out',
                        300.00,
                        'EUR'
                    ],
                    [
                        '2016-01-07',
                        1,
                        'natural',
                        'cash_out',
                        1000.00,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        1,
                        'natural',
                        'cash_out',
                        100.00,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        2,
                        'legal',
                        'cash_in',
                        1000000.00,
                        'EUR'
                    ],
                    [
                        '2016-01-10',
                        3,
                        'natural',
                        'cash_out',
                        1000.00,
                        'EUR'
                    ],
                    [
                        '2016-02-15',
                        1,
                        'natural',
                        'cash_out',
                        300.00,
                        'EUR'
                    ],
                    [
                        '2016-01-07',
                        1,
                        'natural',
                        'cash_out',
                        100.00,
                        'USD'
                    ],
                    [
                        '2016-02-19',
                        5,
                        'natural',
                        'cash_out',
                        3000000,
                        'JPY'
                    ]
                ],
                [
                    '3.60',
                    '3.00',
                    '3.00',
                    '0.06',
                    '0.90',
                    '3.00',
                    '0.30',
                    '5.00',
                    '3.00',
                    '0.90',
                    '0.30',
                    '9000.00'
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
