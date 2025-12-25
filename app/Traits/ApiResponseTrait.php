<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    public function successResponse($data = [], $status = Response::HTTP_OK)
    {
        return response()->json([
            'data' => $data,
        ], $status);
    }

    public function errorResponse($message, $status = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }
}
