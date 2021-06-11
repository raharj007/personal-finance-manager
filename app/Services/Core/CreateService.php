<?php


namespace App\Services\Core;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

abstract class CreateService
{
    protected $repository;
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    abstract protected function rules(): array;

    abstract protected function values(array $array): array;

    public function create(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, $this->rules());
            if ($validator->fails()) {
                return ResultService::error($validator->errors()->first());
            }
            $data = $this->repository->create($this->values($input));
            return ResultService::success($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
