<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php'; 

use CommissionTask\Service\CommissionFeeOutput;
use CommissionTask\Service\CommissionFeeProcessor;
use CommissionTask\Service\CommissionFeeFormatter;

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
