<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @OA\OpenApi(
 * @OA\Info(
 * title="Business Brace 360 Test",
 * version="1.0.0",
 * ),
 * security={
 * {"apikey": {}},
 * {"Authorization": {}}
 * }
 * )
 * @OA\Server(
 * description="Laravel Generator APIs",
 * url="/api"
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 *
 * @OA\SecurityScheme(
 * securityScheme="apikey",
 * type="apiKey",
 * in="header",
 * name="apikey"
 * )
 * @OA\SecurityScheme(
 * securityScheme="Authorization",
 * type="apiKey",
 * in="header",
 * name="Authorization"
 * )
 */

class AppBaseController extends Controller
{
    public function sendResponse($data, $response_message, $response_code='')
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'response_message' => $response_message,
            'response_code'    => $response_code,
        ];


        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = [], $response_code='', $code = 404)
    {
        $response = [
            'success' => false,
            'response_error' => $error,
            'response_code' => $response_code
        ];


        if(!empty($errorMessages)){
            $response['response_message'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function sendSuccess($response_message)
    {
        return Response::json([
            'success' => true,
            'Response_message' => $response_message
        ], 200);
    }
}
