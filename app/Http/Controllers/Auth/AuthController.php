<?php

namespace App\Http\Controllers\Auth;

use App\Services\Core\ResponseService;
use App\Services\Users\CreateService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['register', 'login']]);
    }

    public function register(CreateService $service, Request $request)
    {
        $created = $service->create($request);
        if (!$created->error) {
            return ResponseService::created($created->data);
        } elseif ($created->error && $created->message == ResponseService::ERROR_MSG) {
            return ResponseService::serverError();
        } else {
            return ResponseService::badRequest($created->message);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return ResponseService::unauthorized();
        }

        return ResponseService::success($this->respondWithToken($token));
    }

    private function user()
    {
        return auth('api')->user();
    }

    public function profile()
    {
        return ResponseService::success($this->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return ResponseService::success(null, 'Successfully logged out');
    }

    public function refresh()
    {
        $data = auth('api')->refresh();
        return ResponseService::success($data);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $this->user(),
        ];
    }
}
