<?php


namespace App\Services\Core;


use Illuminate\Http\JsonResponse;

class ResponseService
{
    const SUCCESS_MSG = 'Success.';
    const CREATED_MSG = 'Data successfully created.';
    const UPDATED_MSG = 'Data successfully updated.';
    const DELETED_MSG = 'Data successfully deleted.';
    const ERROR_MSG = 'Internal server error.';
    const ERROR_EMPTY_DATA_MSG = 'Data is not exist.';
    const ERROR_DATA_EXIST_MSG = 'Data already exists.';
    const ERROR_BAD_REQUEST_MSG = 'Bad request.';
    const ERROR_NOT_FOUND_MSG = 'The requested page was not found.';
    const UNAUTHORIZED_MSG = 'Unauthorized.';

    public static function format(bool $status = false, string $message = '', $data = null): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }

    public static function success($data = null, string $message = self::SUCCESS_MSG): JsonResponse
    {
        return response()->json(self::format(true, $message, $data), JsonResponse::HTTP_OK);
    }

    public static function created($data = null, string $message = self::CREATED_MSG): JsonResponse
    {
        return response()->json(self::format(true, $message, $data), JsonResponse::HTTP_CREATED);
    }

    public static function serverError(string $message = self::ERROR_MSG): JsonResponse
    {
        return response()->json(self::format(false, $message), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function notFoundError(string $message = self::ERROR_NOT_FOUND_MSG): JsonResponse
    {
        return response()->json(self::format(false, $message), JsonResponse::HTTP_NOT_FOUND);
    }

    public static function badRequest(string $message = self::ERROR_BAD_REQUEST_MSG): JsonResponse
    {
        return response()->json(self::format(false, $message), JsonResponse::HTTP_BAD_REQUEST);
    }

    public static function unauthorized(string $message = self::UNAUTHORIZED_MSG): JsonResponse
    {
        return response()->json(self::format(false, $message), JsonResponse::HTTP_UNAUTHORIZED);
    }
}
