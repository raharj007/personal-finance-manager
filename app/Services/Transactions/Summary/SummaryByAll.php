<?php


namespace App\Services\Transactions\Summary;


class SummaryByAll extends Summary
{
    protected function params(): ParamsInterface
    {
        // TODO: Implement params() method.
        return new ParamsAll($this->table, $this->date_format);
    }
}
