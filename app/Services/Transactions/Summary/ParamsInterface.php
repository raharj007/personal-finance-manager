<?php


namespace App\Services\Transactions\Summary;


interface ParamsInterface
{
    public function select(): array;
    public function group(): array;
}
