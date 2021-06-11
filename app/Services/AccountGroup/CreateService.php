<?php


namespace App\Services\AccountGroup;


use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;

class CreateService extends \App\Services\Core\CreateService
{
    public function __construct(AccountGroupRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'name' => 'required|unique:account_group',
        ];
    }

    protected function values(array $array): array
    {
        // TODO: Implement values() method.
        return $array;
    }
}
