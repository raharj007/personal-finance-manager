<?php


namespace App\Repositories\Users;


use App\Repositories\BaseRepository;
use App\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new User());
    }
}
