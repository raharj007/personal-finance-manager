<?php


namespace App\Services\Transactions\Params;


use Illuminate\Support\Facades\DB;

class ConstantSelect extends Constant
{
    protected $value;

    protected function init(string $table, string $format)
    {
        $this->date = DB::raw("date_format($table.transaction_date, '$format') as transaction_date");
        $this->type = 'c.type';
        $this->category = 'c.name as category';
        $this->account_group = 'ag.name as group_account';
        $this->account = 'a.name as account';
        $this->value = DB::raw("sum($table.value_in) - sum($table.value_out) as total");
    }

    public function value()
    {
        return $this->value;
    }
}
