<?php


namespace App\Repositories\Categories;


use App\Models\Categories;
use App\Repositories\BaseRepository;

class CategoriesRepository extends BaseRepository implements CategoriesRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Categories());
    }
}
