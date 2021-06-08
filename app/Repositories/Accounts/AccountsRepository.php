<?php


namespace App\Repositories\Accounts;


use App\Models\Accounts;
use App\Repositories\BaseRepository;

class AccountsRepository extends BaseRepository implements AccountsRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Accounts());
    }
}
