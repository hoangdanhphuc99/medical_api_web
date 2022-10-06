<?php
function successResponse($data = [], $message = "Thành công", $code = 200)
{
    return response()->json([
        'msg_code' => 'SUCCESS',
        'msg' => $message == null ? "Thành công" : $message,
        'data' => $data,
        "success" => true,
        "code" => $code

    ], $code);
}

function errorResponse($message = null, $code = 401 , $msg_code = "ERROR")
{
    return response()->json([
        'msg_code' =>  $msg_code,
        'msg' => $message,
        'data' => [],
        "success" => false,
        "code" => $code
    ], $code);
}


function getFirstKeyValue($arr = [])
{
    try {
        foreach ($arr as $key => $value) {
            return array_slice($arr, 0, 1)[$key][0];
    
        }
    } catch (\Throwable $th) {
        return "Đã xãy ra lỗi trong hệ thống! Vui lòng liên hệ admin để được hỗ trợ";
    }
}
