<?php


namespace App\Services\Accounts;


use App\Repositories\Accounts\AccountsRepositoryInterface;

class UpdateService extends \App\Services\Core\UpdateService
{
    public function __construct(AccountsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'name' => 'max:255',
        ];
    }
}
