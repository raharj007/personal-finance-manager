<?php


namespace App\Repositories\Transactions;


use App\Models\Transactions;
use App\Repositories\BaseRepository;

class TransactionsRepository extends BaseRepository implements TransactionsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Transactions());
    }
}
