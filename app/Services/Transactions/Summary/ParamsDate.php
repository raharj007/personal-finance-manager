<?php


namespace App\Services\Transactions\Summary;


use App\Services\Transactions\Params\ConstantGroup;
use App\Services\Transactions\Params\ConstantSelect;

class ParamsDate implements ParamsInterface
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
        return [$select->date(), $select->value()];
    }

    public function group(): array
    {
        // TODO: Implement group() method.
        $group = new ConstantGroup($this->table, $this->format);
        return [$group->date()];
    }
}
