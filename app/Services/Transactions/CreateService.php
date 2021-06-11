<?php


namespace App\Services\Transactions;


use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class CreateService extends \App\Services\Core\CreateService
{
    protected $images;
    public function __construct(TransactionsRepositoryInterface $repository,
                                \App\Services\Images\CreateService $images)
    {
        $this->images = $images;
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'account_id' => 'required',
            'user_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:255',
            'transaction_date' => 'required',
            'file.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    protected function values(array $array): array
    {
        // TODO: Implement values() method.
        $array['id'] = Uuid::uuid4()->getHex();
        return $array;
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

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $validator = Validator::make($input, $this->rules());
            if ($validator->fails()) {
                return ResultService::error($validator->errors()->first());
            }
            $values = $this->values($input);
            $this->upload($request, $values['user_id'], $values['id']);
            $data = $this->repository->create($values);
            DB::commit();
            return ResultService::success($data);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
