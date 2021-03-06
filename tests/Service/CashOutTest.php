<?php

declare(strict_types=1);

namespace CommissionTask\Tests\Service;

use CommissionTask\Service\CashConfiguration;
use CommissionTask\Service\CashOut;
use PHPUnit\Framework\TestCase;

class CashOutTest extends TestCase
{
    /**
     * @var CashOut
     */
    private $cashOut;

    public function setUp()
    {
        $this->cashOut = new CashOut;
    }

    /**
     * @param array $value
     * @param string $expectation
     *
     * @dataProvider dataProviderForGetCommissionTesting
     */
    public function testGetCommission(array $value, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->cashOut->getCommission(0, $value)
        );
    }

    public function dataProviderForGetCommissionTesting(): array
    {
        $total = 10000 * CashConfiguration::CASHOUT_COMMISSION_MULTIPLIER;

        return [
            'test natural type commission' => [
                [
                    2 => 'natural',
                    4 => 10000
                ],
                $total 
            ],
            'test legal type commission' => [
                [
                    2 => 'legal',
                    4 => 10000
                ],
                $total
            ],
            'test legal type minimum commission' => [
                [
                    2 => 'legal',
                    4 => 100
                ],
                CashConfiguration::CASHOUT_MINIMUM_VALUE
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
        $this->cashOut->getCommission(0, $value);
    }

    /**
     * @return array
     */
    public function dataProviderForExceptionTesting(): array
    {
        return [
            'test exception for invalid amount' => [
                [
                    2 => 'natural',
                    4 => 'invalid amount'
                ],
                'Invalid amount on line 1'
            ],
            'test exception for invalid user type' => [
                [
                    2 => 'ivalid user type',
                    4 => 999999
                ],
                'Invalid user type on line 1'
            ],
        ];
    }
}
