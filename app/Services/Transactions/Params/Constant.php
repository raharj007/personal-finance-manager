<?php


namespace App\Services\Transactions\Params;



abstract class Constant
{
    protected $date;
    protected $type;
    protected $category;
    protected $account_group;
    protected $account;
    public function __construct(string $table, string $format)
    {
        $this->init($table, $format);
    }

    abstract protected function init(string $table, string $format);

    public function date()
    {
        return $this->date;
    }

    public function type()
    {
        return $this->type;
    }

    public function category()
    {
        return $this->category;
    }

    public function accountgroup()
    {
        return $this->account_group;
    }

    public function account()
    {
        return $this->account;
    }
}
