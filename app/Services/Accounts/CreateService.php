<?php


namespace App\Services\Accounts;


use App\Repositories\Accounts\AccountsRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateService extends \App\Services\Core\CreateService
{
    public function __construct(AccountsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'account_group_id' => 'required',
            'user_id' => 'required',
            'name' => 'required|max:255|unique:accounts',
        ];
    }

    protected function values(array $array): array
    {
        // TODO: Implement values() method.
        $array['id'] = Uuid::uuid4()->getHex();
        return $array;
    }
}
