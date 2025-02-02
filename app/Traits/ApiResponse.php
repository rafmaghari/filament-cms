<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    protected function emptyDataResponse(): Response
    {
        return response()->noContent();
    }

    protected function successResponse($message = '', $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message], $statusCode);
    }

    protected function errorResponse($message = '', int $statusCode = 400): JsonResponse
    {
        return response()->json(['message' => $message], $statusCode);
    }
}
