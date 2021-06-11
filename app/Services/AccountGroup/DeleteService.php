<?php


namespace App\Services\AccountGroup;


use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;

class DeleteService extends \App\Services\Core\DeleteService
{
    public function __construct(AccountGroupRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
