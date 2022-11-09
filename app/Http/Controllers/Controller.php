<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getResponse($status, $message = '', $data = [])
    {
        $response['status'] = $status;
        $response['message'] = $message;
        if ($data) {
            $response['data'] = $data;
        }
        return json_encode($response);
    }
}
