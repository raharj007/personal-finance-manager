<?php


namespace App\Services\Core;


use Illuminate\Support\Facades\Log;

abstract class DeleteService
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    protected function params($params)
    {
        return [
            'id' => $params,
        ];
    }

    public function destroy($params)
    {
        try {
            $deleted = $this->repository->delete($this->params($params));
            if ($deleted > 0) {
                return ResultService::success();
            } else {
                return ResultService::error(ResponseService::ERROR_EMPTY_DATA_MSG);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }

    public function restore($id)
    {
        try {
            $restore = $this->repository->restore($id);
            if ($restore > 0) {
                return ResultService::success();
            } else {
                return ResultService::error(ResponseService::ERROR_EMPTY_DATA_MSG);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
