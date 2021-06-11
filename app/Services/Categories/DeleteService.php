<?php


namespace App\Services\Categories;


use App\Repositories\Categories\CategoriesRepositoryInterface;

class DeleteService extends \App\Services\Core\DeleteService
{
    public function __construct(CategoriesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
