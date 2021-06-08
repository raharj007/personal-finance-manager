<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function data(array $conditions = [], array $columns = ['*'])
    {
        return $this->model->newQuery()
            ->where($conditions)
            ->get($columns);
    }

    public function create(array $values)
    {
        return $this->model->newQuery()
            ->create($values);
    }

    public function update(array $conditions, array $values)
    {
        return $this->model->newQuery()
            ->where($conditions)
            ->update($values);
    }

    public function delete(array $conditions)
    {
        return $this->model->newQuery()
            ->where($conditions)
            ->delete();
    }
}
