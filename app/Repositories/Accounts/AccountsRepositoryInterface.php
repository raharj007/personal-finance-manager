<?php


namespace App\Repositories\Accounts;


interface AccountsRepositoryInterface
{
    public function data(array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
}
