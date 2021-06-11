<?php


namespace App\Services\Images;


use App\Repositories\Images\ImagesRepositoryInterface;
use App\Services\Core\ResultService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteService extends \App\Services\Core\DeleteService
{
    const DELETE_BY_ID = 'delete_by_id';
    const DELETE_BY_PARENT = 'delete_by_parent';

    public function __construct(ImagesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function params($params)
    {
        return $params->type == self::DELETE_BY_ID ?
            ['id' => $params->id] : ['parent_id' => $params->id];
    }
}
