<?php


namespace App\Services\Transactions\Summary;


use App\Repositories\Transactions\TransactionsRepositoryInterface;

class SummaryByDate extends Summary
{
    protected function params(): ParamsInterface
    {
        // TODO: Implement params() method.
        return new ParamsDate($this->table, $this->date_format);
    }
}
