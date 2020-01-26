<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Tests\Service;

use Paysera\CommissionTask\Service\CommissionFeeFormatter;
use PHPUnit\Framework\TestCase;

class CommissionFeeFormatterTest extends TestCase
{
    /**
     * @var CommissionFeeFormatter
     */
    private $commissionFeeFormatter;

    public function setUp()
    {
        $this->commissionFeeFormatter = new CommissionFeeFormatter;
    }

    /**
     * @param int $value
     * @param string $expectation
     *
     * @dataProvider dataProviderForFormatTesting
     */
    public function testFormat(int $value, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            $this->commissionFeeFormatter->format($value)
        );
    }

    public function dataProviderForFormatTesting(): array
    {
        return [
            'test format with 2 decimal places' => [4, '4.00'],
            'test format number with 2 decimal places already' => [22.00, '22.00'],
        ];
    }
}
