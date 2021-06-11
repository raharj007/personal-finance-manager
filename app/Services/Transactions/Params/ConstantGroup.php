<?php


namespace App\Services\Transactions\Params;


use Illuminate\Support\Facades\DB;

class ConstantGroup extends Constant
{
    protected function init(string $table, string $format)
    {
        $this->date = DB::raw("date_format($table.transaction_date, '$format')");
        $this->type = 'c.type';
        $this->category = "$table.category_id";
        $this->account_group = 'a.account_group_id';
        $this->account = "$table.account_id";
    }
}
