<?php

/*
|--------------------------------------------------------------------------
| Json Format For All Api's
|--------------------------------------------------------------------------
*/

if (! function_exists('sendResponse'))
{
    function sendResponse($success, $result, $message, $code)
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $result,
            'code' => $code,
        ];
        
        return response()->json($response, 200);
    }

}

// End Function
