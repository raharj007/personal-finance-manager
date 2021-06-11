<?php


namespace App\Services\Categories;


use App\Repositories\Categories\CategoriesRepositoryInterface;
use Illuminate\Http\Request;

class DataService extends \App\Services\Core\DataService
{
    public function __construct(CategoriesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function filters(Request $request): array
    {
        // TODO: Implement filters() method.
        $conditions = [];
        $this->addFilter($request, 'type', $conditions);
        return $conditions;
    }

    protected function searchable(): array
    {
        // TODO: Implement searchable() method.
        return ['id', 'name'];
    }

    protected function params($params): array
    {
        return ['type' => $params];
    }
}
