<?php

namespace App\Http\Controllers\Config;

use App\Services\Categories\DataService;
use App\Services\Core\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
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

    public function dropdown(DataService $service, $type)
    {
        $result = $service->dropdown($type);
        if (!$result->error) {
            return ResponseService::success($result->data);
        }
        return ResponseService::serverError();
    }
}
