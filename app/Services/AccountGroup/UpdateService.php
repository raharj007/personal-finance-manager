<?php


namespace App\Services\AccountGroup;


use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;

class UpdateService extends \App\Services\Core\UpdateService
{
    public function __construct(AccountGroupRepositoryInterface $repository)
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
