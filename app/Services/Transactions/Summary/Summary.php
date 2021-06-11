<?php


namespace App\Services\Transactions\Summary;


use App\Repositories\Transactions\TransactionsRepositoryInterface;
use App\Services\Core\ResultService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class Summary
{
    protected $repository;
    protected $table;
    protected $date_format;
    public function __construct(TransactionsRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->table = 'transactions';
    }

    abstract protected function params(): ParamsInterface;

    public function summary_type(string $format = 'daily')
    {
        if ($format == 'daily') {
            $this->date_format = '%Y-%m-%d';
        } elseif ($format == 'monthly') {
            $this->date_format = '%Y-%m';
        }
    }

    private function conditions(Request $request): array
    {
        $start_date = $request->start_date ?? Carbon::now('GMT+7')->subMonth()->format('Y-m-d');
        $end_date = $request->end_date ?? Carbon::now('GMT+7')->format('Y-m-d');
        return [
            "$this->table.user_id" => $request->user_id,
            ["$this->table.transaction_date", '>=', $start_date],
            ["$this->table.transaction_date", '<=', $end_date],
        ];
    }

    public function data(Request $request)
    {
        try {
            $params = $this->params();
            $data = $this->repository->summary($params->select(), $this->conditions($request), $params->group());
            return ResultService::success($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResultService::error();
        }
    }
}
