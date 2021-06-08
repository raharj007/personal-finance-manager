<?php


namespace App\Repositories\AccountGroup;


use App\Models\AccountGroup;
use App\Repositories\BaseRepository;

class AccountGroupRepository extends BaseRepository implements AccountGroupRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new AccountGroup());
    }
}
