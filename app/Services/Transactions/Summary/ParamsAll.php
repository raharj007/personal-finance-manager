<?php


namespace App\Services\Transactions\Summary;


use App\Services\Transactions\Params\ConstantGroup;
use App\Services\Transactions\Params\ConstantSelect;

class ParamsAll implements ParamsInterface
{
    protected $table;
    protected $format;
    public function __construct(string $table, string $format)
    {
        $this->table = $table;
        $this->format = $format;
    }

    public function select(): array
    {
        // TODO: Implement select() method.
        $select = new ConstantSelect($this->table, $this->format);
        return [
            $select->date(),
            $select->type(),
            $select->category(),
            $select->accountgroup(),
            $select->account(),
            $select->value()
        ];
    }

    public function group(): array
    {
        // TODO: Implement group() method.
        $group = new ConstantGroup($this->table, $this->format);
        return [
            $group->date(),
            $group->type(),
            $group->category(),
            $group->accountgroup(),
            $group->account()
        ];
    }
}
