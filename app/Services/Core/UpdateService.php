<?php


namespace App\Services\Core;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

abstract class UpdateService
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    abstract protected function rules(): array;

    protected function params($params): array
    {
        return [
            'id' => $params,
        ];
    }

    public function update(Request $request, $params)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, $this->rules());
            if ($validator->fails()) {
                return ResultService::error($validator->errors()->first());
            }
            $updated = $this->repository->update($this->params($params), $input);
            if ($updated > 0) {
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
