<?php

declare(strict_types=1);

namespace CommissionTask\Service;

use CommissionTask\Interfaces\OutputInterface;

class CommissionFeeOutput implements OutputInterface
{
    /**
     * @param array $data
     */
    public function show(array $data): void
    {
        foreach ($data as $d) {
            fwrite(STDOUT, $d."\n");
        }
    }
}
