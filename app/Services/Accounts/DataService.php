<?php


namespace App\Services\Accounts;


use App\Repositories\Accounts\AccountsRepositoryInterface;
use Illuminate\Http\Request;

class DataService extends \App\Services\Core\DataService
{
    public function __construct(AccountsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Request $request): array
    {
        // TODO: Implement filters() method.
        $conditions = ['user_id' => $request->user_id];
        $this->addFilter($request, 'account_group_id', $conditions);
        return $conditions;
    }

    protected function searchable(): array
    {
        // TODO: Implement searchable() method.
        return ['id', 'name', 'description'];
    }

    protected function params($params): array
    {
        return (gettype($params) == 'object') ? ['user_id' => $params->user_id] : ['user_id' => $params];
    }
}
