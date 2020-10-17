<?php
use Illuminate\Http\Response;;

function sendResponse( $arr, $status_code, $message , $result )
{
    $response = [
        'status_code' => $status_code,
        'status_message' => $message,
        $arr    => $result,
    ];

    return response()->json($response);
}

function sendError($error, $errorMessages = [], $code = 404)
{
    $response = [
        'success' => false,
        'message' => $error,
    ];


    if(!empty($errorMessages)){
        $response['data'] = $errorMessages;
    }


    return response()->json($response, $code);
}