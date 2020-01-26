<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Tests\Service;

use Paysera\CommissionTask\Service\CashIn;
use PHPUnit\Framework\TestCase;

class CashInTest extends TestCase
{
    /**
     * @var CashIn
     */
    private $cashIn;

    public function setUp()
    {
        $this->cashIn = new CashIn();
    }

    /**
     * @param array $value
     * @param int $expectation
     *
     * @dataProvider dataProviderForGetCommissionTesting
     */
    public function testGetCommission(array $value, $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->cashIn->getCommission(0, $value)
        );
    }

    /**
     * @return array
     */
    public function dataProviderForGetCommissionTesting(): array
    {
        return [
            'test .03% commision' => [
                [
                    4 => 10000
                ],
                3
            ],
            'test if it returns 5 as maximum value' => [
                [
                    4 => 999999
                ],
                5
            ]
        ];
    }

    public function testException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid value on line 1');

        $this->cashIn->getCommission(
            0,
            [
                4 => 'invalid value'
            ]
        );
    }
}
