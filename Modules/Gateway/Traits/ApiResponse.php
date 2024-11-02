<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 17-08-2021
 */

namespace Modules\Gateway\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Prepare response.
     *
     * @return array
     */
    public function response($data = [], int $statusCode = Response::HTTP_OK, string $message = '')
    {
        if (empty($message)) {
            $message = Response::$statusTexts[$statusCode];
        }

        return response()->json([
            'response' => [
                'status' => [
                    'code' => $statusCode,
                    'message' => $message,
                ],
                'records' => $data,
            ],
        ]);
    }

    /**
     * Success Response
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function successResponse($data = [], int $statusCode = Response::HTTP_OK, string $message = '')
    {
        return $this->response($data, $statusCode, $message);
    }

    /**
     * Error Response
     *
     * @param  array  $errors
     * @return JsonResponse
     */
    public function errorResponse($errors = [], int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, string $message = '')
    {
        return $this->response($errors, $statusCode, $message);
    }

    /**
     * Response with status code 200.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function okResponse($data = [], string $message = '')
    {
        return $this->successResponse($data, Response::HTTP_OK, $message);
    }

    /**
     * Response with status code 201.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function createdResponse($data = [], string $message = '')
    {
        return $this->successResponse($data, Response::HTTP_CREATED, $message);
    }

    /**
     * Response with status code 400.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function badRequestResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_BAD_REQUEST, $message);
    }

    /**
     * Response with status code 401.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function unauthorizedResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_UNAUTHORIZED, $message);
    }

    /**
     * Response with status code 403.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function forbiddenResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_FORBIDDEN, $message);
    }

    /**
     * Response with status code 404.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function notFoundResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_NOT_FOUND, $message);
    }

    /**
     * Response with status code 409.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function conflictResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_CONFLICT, $message);
    }

    /**
     * Response with status code 422.
     *
     * @param  array  $data
     * @return JsonResponse
     */
    public function unprocessableResponse($data = [], string $message = '')
    {
        return $this->errorResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }
}
