<?php


namespace App\Services\Transactions;


use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResponseService;
use App\Services\Core\ResultService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteService extends \App\Services\Core\DeleteService
{
    protected $images;
    public function __construct(TransactionsRepositoryInterface $repository, \App\Services\Images\DeleteService $images)
    {
        $this->images = $images;
        parent::__construct($repository);
    }

    public function destroy($params)
    {
        try {
            DB::beginTransaction();
            $delete_images = $this->images->destroy((object)[
                'type' => \App\Services\Images\DeleteService::DELETE_BY_PARENT,
                'id' => $params,
            ]);
            $deleted = $this->repository->delete($this->params($params));
            if ((!$delete_images->error || ($delete_images->error && $delete_images->message == ResponseService::ERROR_EMPTY_DATA_MSG)) && $deleted > 0) {
                DB::commit();
                return ResultService::success();
            } else {
                DB::rollBack();
                return ResultService::error();
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
