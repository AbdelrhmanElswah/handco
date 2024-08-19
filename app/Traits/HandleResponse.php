<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandleResponse
{
    public int $pagination = 30;
    public int $redis_time = 30;

    public int $limit = 3;

    public int $days = 14;

    public function response($data, $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status);
    }

    public function successWithData($data, $msg, $dataExtra = null, $status_code = Response::HTTP_OK): JsonResponse
    {
        //        $sortedData = $data->sortByDesc('created_at')->all();

        return $this->response([
            'status' => true,
            'status_code' => $status_code,
            'massage' => $msg,
            'data' => $data,
            'extra_data' => $dataExtra,
        ], 200);
    }

    public function successMessage($msg = '', $status_code = '200')
    {
        return [
            'status' => true,
            'status_code' => $status_code,
            'massage' => $msg,
        ];
    }

    public function fail($code = 'internal_error', $msg = 'Internal Server Error', $errors = [], $status_code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->response([
            'status' => false,
            'status_code' => $status_code,
            'message' => $msg,
            'error_code' => $code,
            'error' => $errors,
        ], $status_code);
    }

    public function createdResponse($data, $msg, $status_code = Response::HTTP_CREATED): JsonResponse
    {
        return $this->response([
            'status' => true,
            'status_code' => $status_code,
            'massage' => $msg,
            'data' => $data,
        ], 200);
    }

    public function unauthorizedResponse($msg): JsonResponse
    {
        return $this->fail('unauthorized', $msg, 'UNAUTHORIZED', Response::HTTP_UNAUTHORIZED);
    }

    public function badRequestResponse($msg): JsonResponse
    {
        return $this->fail('bad request', $msg, 'BAD REQUEST', Response::HTTP_BAD_REQUEST);
    }
}
