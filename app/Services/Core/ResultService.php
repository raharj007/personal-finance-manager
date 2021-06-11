<?php


namespace App\Services\Core;


class ResultService
{
    static function success($data = null): \stdClass
    {
        return (object)[
            'error' => false,
            'message' => ResponseService::SUCCESS_MSG,
            'data' => $data,
        ];
    }

    static function error($message = ResponseService::ERROR_MSG, $data = null): \stdClass
    {
        return (object)[
            'error' => true,
            'message' => $message,
            'data' => $data
        ];
    }
}
