<?php

declare(strict_types=1);

namespace App\Libraries;

use Laminas\Diactoros\Response\JsonResponse;

class ApiResponse
{
    private static function createResponse(bool $success, string $message, array $data = [], int $code = 200)
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function success(array $data = [], string $message = 'Success')
    {
        return self::createResponse(true, $message, $data);
    }

    public static function error(string $message = 'Error', int $code = 500)
    {
        return self::createResponse(false, $message, [], $code);
    }
}
