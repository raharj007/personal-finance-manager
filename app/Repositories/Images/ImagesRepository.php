<?php


namespace App\Repositories\Images;


use App\Models\Images;
use App\Repositories\BaseRepository;

class ImagesRepository extends BaseRepository implements ImagesRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Images());
    }
}
