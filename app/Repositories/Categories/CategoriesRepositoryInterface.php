<?php


namespace App\Repositories\Categories;


interface CategoriesRepositoryInterface
{
    public function data(array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
}
