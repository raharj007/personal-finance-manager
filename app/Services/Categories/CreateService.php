<?php


namespace App\Services\Categories;


use App\Repositories\Categories\CategoriesRepositoryInterface;

class CreateService extends \App\Services\Core\CreateService
{
    public function __construct(CategoriesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'type' => 'required|in:in,out',
            'name' => 'required|max:255|unique:categories',
        ];
    }

    protected function values(array $array): array
    {
        // TODO: Implement values() method.
        return $array;
    }
}
