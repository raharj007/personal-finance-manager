<?php


namespace App\Repositories\Users;


interface UserRepositoryInterface
{
    public function data(array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
}
