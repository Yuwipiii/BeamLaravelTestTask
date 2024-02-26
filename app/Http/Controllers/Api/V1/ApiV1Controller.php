<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class ApiV1Controller
 * @package App\Http\Controllers\Api\V1
 *
 * @OA\Info(
 *     version="1.0",
 *     title="Example for response examples value"
 *
 * )
 *
 * @OA\PathItem(path="/api/v1")
 */
abstract class ApiV1Controller extends Controller
{
    protected function success(array|Collection|Model $data = [])
    {
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
}

