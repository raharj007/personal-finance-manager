<?php


namespace App\Services\AccountGroup;



use App\Repositories\AccountGroup\AccountGroupRepositoryInterface;
use Illuminate\Http\Request;

class DataService extends \App\Services\Core\DataService
{
    public function __construct(AccountGroupRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Request $request): array
    {
        // TODO: Implement filters() method.
        return [];
    }

    protected function searchable(): array
    {
        // TODO: Implement searchable() method.
        return ['id', 'name'];
    }

    protected function trashCondition(Request $request): array
    {
        // TODO: Implement trashCondition() method.
        return [];
    }


}
