<?php


namespace App\Services\Images;



use App\Repositories\Images\ImagesRepositoryInterface;
use App\Services\Core\ResponseService;
use App\Services\Core\ResultService;
use Illuminate\Support\Facades\Log;

class DataService
{
    protected $repository;
    public function __construct(ImagesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function data($parent_id = '')
    {
        try {
            return $this->repository->all(['parent_id' => $parent_id]);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
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
}
