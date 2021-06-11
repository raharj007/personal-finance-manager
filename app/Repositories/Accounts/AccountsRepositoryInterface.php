<?php


namespace App\Repositories\Accounts;


interface AccountsRepositoryInterface
{
    public function all(array $filter = [], array $search = [], array $columns = ['*']);
    public function pagination(int $page = 10, array $filter = [], array $search = [], array $columns = ['*']);
    public function find(array $conditions = [], array $columns = ['*']);
    public function trashed(int $page = 10, array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
    public function restore($id);
}
