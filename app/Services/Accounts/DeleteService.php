<?php


namespace App\Services\Accounts;


use App\Repositories\Accounts\AccountsRepositoryInterface;

class DeleteService extends \App\Services\Core\DeleteService
{
    public function __construct(AccountsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
