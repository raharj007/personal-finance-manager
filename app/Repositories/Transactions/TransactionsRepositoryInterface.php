<?php


namespace App\Repositories\Transactions;


interface TransactionsRepositoryInterface
{
    public function data(array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
}
