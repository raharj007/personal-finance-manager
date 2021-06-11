<?php

namespace App\Http\Controllers\Transaction;

use App\Services\Accounts\DeleteService;
use App\Services\Accounts\CreateService;
use App\Services\Accounts\DataService;
use App\Services\Accounts\UpdateService;
use App\Services\Core\ResponseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
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

    public function dropdown(DataService $service, $user_id)
    {
        $result = $service->dropdown($user_id);
        if (!$result->error) {
            return ResponseService::success($result->data);
        }
        return ResponseService::serverError();
    }

    public function create(CreateService $service, Request $request)
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

    public function update(UpdateService $service, Request $request, $id)
    {
        $updated = $service->update($request, $id);
        if (!$updated->error) {
            return ResponseService::success();
        } elseif ($updated->error && $updated->message == ResponseService::ERROR_MSG) {
            return ResponseService::serverError();
        } else {
            return ResponseService::badRequest($updated->message);
        }
    }

    public function delete(DeleteService $service, $id)
    {
        $deleted = $service->destroy($id);
        if (!$deleted->error) {
            return ResponseService::success();
        } elseif ($deleted->error && $deleted->message == ResponseService::ERROR_MSG) {
            return ResponseService::serverError();
        } else {
            return ResponseService::badRequest($deleted->message);
        }
    }

    public function trashed(DataService $service, Request $request)
    {
        $result = $service->trashed($request);
        if (!$result->error) {
            return ResponseService::success($result->data);
        }
        return ResponseService::serverError();
    }

    public function restore(DeleteService $service, $id)
    {
        $restored = $service->restore($id);
        if (!$restored->error) {
            return ResponseService::success();
        } elseif ($restored->error && $restored->message == ResponseService::ERROR_MSG) {
            return ResponseService::serverError();
        } else {
            return ResponseService::badRequest($restored->message);
        }
    }
}
