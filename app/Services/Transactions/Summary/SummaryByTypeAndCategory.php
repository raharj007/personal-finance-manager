<?php


namespace App\Services\Transactions\Summary;


class SummaryByTypeAndCategory extends Summary
{
    protected function params(): ParamsInterface
    {
        // TODO: Implement params() method.
        return new ParamsTypeCategory($this->table, $this->date_format);
    }
}
