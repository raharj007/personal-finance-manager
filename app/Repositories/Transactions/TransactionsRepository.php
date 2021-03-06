<?php


namespace App\Repositories\Transactions;


use App\Models\Transactions;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class TransactionsRepository extends BaseRepository implements TransactionsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Transactions());
    }

    protected function data()
    {
        return parent::data()->with(['account', 'user', 'category']); // TODO: Change the autogenerated stub
    }



    public function summary(array $columns = ['*'], array $conditions = [], array $group = [])
    {
        // TODO: Implement summary() method.
        return $this->model->newQuery()
            ->select($columns)
            ->join('accounts as a', 'transactions.account_id', '=', 'a.id')
            ->join('account_group as ag', 'a.account_group_id', '=', 'ag.id')
            ->join('categories as c', 'transactions.category_id', '=', 'c.id')
            ->where($conditions)
            ->groupBy($group)
            ->get();
    }
}
