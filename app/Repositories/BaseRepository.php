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

    protected function data()
    {
        return $this->model->newQuery();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function dataWithConditions(array $filter = [], array $search = [])
    {
        return $this->data()
            ->where($filter)
            ->where(function ($query) use ($search) {
                foreach ($search as $key => $value) {
                    $query->orWhere($key, 'like', $value);
                }
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all(array $filter = [], array $search = [], array $columns = ['*'])
    {
        return $this->dataWithConditions($filter, $search)->get($columns);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function pagination(int $page = 10, array $filter = [], array $search = [], array $columns = ['*'])
    {
        return $this->dataWithConditions($filter, $search)->select($columns)->paginate($page);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function find(array $conditions = [], array $columns = ['*'])
    {
        return $this->data()
            ->where($conditions)
            ->first($columns);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function trashed(int $page = 10, array $conditions = [], array $columns = ['*'])
    {
        return $this->model->newQuery()
            ->onlyTrashed()
            ->select($columns)
            ->where($conditions)
            ->paginate($page);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    public function create(array $values)
    {
        return $this->model->newQuery()
            ->create($values);
    }

    /**
     * @return int
     */
    public function update(array $conditions, array $values)
    {
        return $this->model->newQuery()
            ->where($conditions)
            ->update($values);
    }

    /**
     * @return mixed
     */
    public function delete(array $conditions)
    {
        return $this->model->newQuery()
            ->where($conditions)
            ->delete();
    }

    /**
     * @return mixed
     */
    public function restore($id)
    {
        return $this->model->newQuery()
            ->withTrashed()
            ->where('id', '=', $id)
            ->restore();
    }
}
