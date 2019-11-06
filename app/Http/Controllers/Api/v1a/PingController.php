<?php

namespace App\Http\Controllers\Api\v1a;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function ping()
    {
        return response()->json([
            'error' => false,
            'datas'  => "Pong",
        ], 200);
    }
}

