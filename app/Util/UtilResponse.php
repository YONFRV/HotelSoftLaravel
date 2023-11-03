<?php
namespace App\Util;

class UtilResponse
{
    public function responseOk($process, $data){
            return response()->json([
                'status' => true,
                'message' => $process .' successfully',
                'data' => $data
            ], 200);
    }

    /*public function responseFail($validator){
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->all()
        ], 400);
    }*/


    public function responseFail($message){
        return response()->json([
            'status' => false,
            'errors' => $message
        ], 400);
    }

    public function responseDuplicate($process){
        return response()->json([
            'status' => false,
            'errors' => [$process .'already exists']
        ], 400);
    }
}