<?php

declare(strict_types=1);

namespace Paysera\CommissionTask\Service;

use Paysera\CommissionTask\Interfaces\OutputInterface;

class CommissionFeeOutput implements OutputInterface
{
    public function show(array $data): void
    {
        foreach ($data as $d) {
            fwrite(STDOUT, $d."\n");
        }
    }
}
