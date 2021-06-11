<?php


namespace App\Services\Core;


use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class DataService
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    abstract protected function filters(Request $request): array;

    abstract protected function searchable(): array;

    protected function addFilter(Request $request, string $string, array &$conditions)
    {
        $key = 'filters_'.$string;
        if ($request->has($key)) {
            $conditions[$string] = $request->$key;
        }
    }

    protected function search(Request $request): array
    {
        $conditions = [];
        if ($request->has('search_value')) {
            foreach ($this->searchable() as $column) {
                $conditions[$column] = "%$request->search_value%";
            }
        }
        return $conditions;
    }

    protected function page(Request $request): int
    {
        if ($request->has('page_length')) {
            return $request->page_length;
        }
        return 10;
    }

    public function data(Request $request)
    {
        try {
            $data = $this->repository->pagination(
                $this->page($request),
                $this->filters($request),
                $this->search($request)
            );
            return ResultService::success($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }

    public function find($id)
    {
        try {
            $data = $this->repository->find(['id' => $id]);
            if (!empty($data)) {
                return ResultService::success($data);
            } else {
                return ResultService::error(ResponseService::ERROR_EMPTY_DATA_MSG);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }

    protected function params($params): array
    {
        return [];
    }

    protected function dropdownColumns(): array
    {
        return ['id as value', 'name as text'];
    }

    public function dropdown($params = null)
    {
        try {
            $data = $this->repository->all($this->params($params), [], $this->dropdownColumns());
            return ResultService::success($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }

    public function trashed(Request $request)
    {
        try {
            $data = $this->repository->trashed($this->page($request), $this->params($request));
            return ResultService::success($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
