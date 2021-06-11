<?php


namespace App\Services\Transactions;


use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResponseService;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UpdateService extends \App\Services\Core\UpdateService
{
    protected $images;
    public function __construct(TransactionsRepositoryInterface $repository, \App\Services\Images\CreateService $images)
    {
        $this->images = $images;
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'user_id' => 'required',
            'title' => 'max:255',
            'file.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * @throws \Exception
     */
    private function upload(Request $request, string $user_id, string $transaction_id)
    {
        $file = $request->file('file');
        if ($file) {
            $this->images->uploads($file, $user_id, $transaction_id);
        }
    }

    public function update(Request $request, $params)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $validator = Validator::make($input, $this->rules());
            if ($validator->fails()) {
                return ResultService::error($validator->errors()->first());
            }
            $this->upload($request, $input['user_id'], $params);
            $updated = $this->repository->update($this->params($params), $input);
            if ($updated > 0) {
                DB::commit();
                return ResultService::success();
            } else {
                DB::rollBack();
                return ResultService::error(ResponseService::ERROR_EMPTY_DATA_MSG);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
