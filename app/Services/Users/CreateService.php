<?php


namespace App\Services\Users;


use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CreateService extends \App\Services\Core\CreateService
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ];
    }

    protected function values(array $array): array
    {
        // TODO: Implement values() method.
        return [
            'id' => Uuid::uuid4()->getHex(),
            'name' => $array['name'],
            'email' => $array['email'],
            'password' => bcrypt($array['password']),
        ];
    }
}
