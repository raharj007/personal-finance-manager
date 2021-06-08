<?php


namespace App\Repositories\Images;


interface ImagesRepositoryInterface
{
    public function data(array $conditions = [], array $columns = ['*']);
    public function create(array $values);
    public function update(array $conditions, array $values);
    public function delete(array $conditions);
}
