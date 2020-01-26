<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Service;

use Paysera\CommissionTask\Interfaces\FormatterInterface;

class CommissionFeeProcessor
{
    /**
     * @var string CASH_IN
     */
    private const CASH_IN = 'cash_in';

    /**
     * @var string CASH_OUT
     */
    private const CASH_OUT = 'cash_out';

    /**
     * @var FormatterInterface
     */
    private $formatter;

    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    public function process(array $csv): array
    {
        $result = [];
        foreach ($csv as $key => $value) {
            if (!isset($value[3])) {
                throw new \Exception('Invalid csv format');
            }

            $operationType = null;

            switch ($value[3]) {
                case self::CASH_IN:
                    $operationType = new CashIn();
                    break;
                case self::CASH_OUT:
                    $operationType = new CashOut();
                    break;
            }

            if (!$operationType) {
                throw new \Exception(sprintf('Invalid operation type on line %s', $key + 1));
            }

            $result[] = $this->formatter->format(
                $operationType->getCommission($key, $value)
            );
        }

        return $result;
    }
}
