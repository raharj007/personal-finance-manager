<?php


namespace App\Services\Transactions;


use App\Repositories\Transactions\TransactionsRepositoryInterface;
use Illuminate\Http\Request;

class DataService extends \App\Services\Core\DataService
{
    public function __construct(TransactionsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Request $request): array
    {
        // TODO: Implement filters() method.
        $conditions = ['user_id' => $request->user_id];
        $this->addFilter($request, 'account_id', $conditions);
        $this->addFilter($request, 'category_id', $conditions);
        $this->addFilter($request, 'transaction_date', $conditions);
        return $conditions;
    }

    protected function searchable(): array
    {
        // TODO: Implement searchable() method.
        return [
            'id',
            'title',
            'description',
            'value_in',
            'value_out',
        ];
    }

    protected function params($params): array
    {
        return (gettype($params) == 'object') ? ['user_id' => $params->user_id] : ['user_id' => $params];
    }
}
