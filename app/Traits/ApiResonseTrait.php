<?php
namespace App\Traits;
trait ApiResonseTrait{
    public function apiresponce($data = null,$message = null,$status = null){
        $array = [
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
        return response($array,$status);
    }
}