<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Core\ResponseService;
use App\Services\Images\DataService;
use App\Services\Images\DeleteService;
use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function show(DataService $service, $id)
    {
        $result = $service->find($id);
        if (!$result->error) {
            return ResponseService::success($result->data);
        } elseif ($result->error && $result->message == ResponseService::ERROR_EMPTY_DATA_MSG) {
            return ResponseService::notFoundError($result->message);
        }
        return ResponseService::serverError();
    }

    public function delete(DeleteService $service, $id)
    {
        $deleted = $service->destroy((object)['type' => DeleteService::DELETE_BY_ID, 'id' => $id]);
        if (!$deleted->error) {
            return ResponseService::success();
        } elseif ($deleted->error && $deleted->message == ResponseService::ERROR_MSG) {
            return ResponseService::serverError();
        } else {
            return ResponseService::badRequest($deleted->message);
        }
    }
}
