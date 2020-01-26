<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Service;

include('vendor\autoload.php');

use Paysera\CommissionTask\Service\CommissionFeeOutput;
use Paysera\CommissionTask\Service\CommissionFeeProcessor;
use Paysera\CommissionTask\Service\CommissionFeeFormatter;

try {
    $csv = array_map('str_getcsv', file($argv[1]));

    $commissionFeeProcessor = new CommissionFeeProcessor(
        new CommissionFeeFormatter
    );

    $output = new CommissionFeeOutput();

    $output->show(
        $commissionFeeProcessor->process($csv)
    );
} catch (\Exception $e) {
    fwrite(STDOUT, $e->getMessage());
}
