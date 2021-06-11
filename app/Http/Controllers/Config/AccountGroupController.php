<?php

namespace App\Http\Controllers\Config;

use App\Services\AccountGroup\DataService;
use App\Services\Core\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function data(DataService $service, Request $request)
    {
        $result = $service->data($request);
        if (!$result->error) {
            return ResponseService::success($result->data);
        }
        return ResponseService::serverError();
    }

    public function dropdown(DataService $service)
    {
        $result = $service->dropdown();
        if (!$result->error) {
            return ResponseService::success($result->data);
        }
        return ResponseService::serverError();
    }
}
