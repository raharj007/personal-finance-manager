<?php


namespace App\Services\Categories;


use App\Repositories\Categories\CategoriesRepositoryInterface;

class UpdateService extends \App\Services\Core\UpdateService
{
    public function __construct(CategoriesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'name' => 'max:255'
        ];
    }
}
