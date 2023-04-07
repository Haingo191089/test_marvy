<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function formatValidatorError ($err) {
        if (!is_array($err)) {
            return $err;
        }

        $formated = [];
        foreach ($err as $key => $value) {
            $formated[$key] = $value[0];
        }
        return $formated;
    }

    protected function reponseSuccess ($data = []) {
        $response = [
            STATUS => true,
            ERR_MSG => [],
            DATA => $data,
        ];

        return response()->json($response);
    }

    protected function reponseFail ($errMsg = '') {
        $response = [
            STATUS => false,
            ERR_MSG => $errMsg,
            DATA => [],
        ];

        return response()->json($response);
    }

    
}
