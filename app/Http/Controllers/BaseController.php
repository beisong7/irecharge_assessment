<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * This is the default landing of the API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function welcome(){
        //todo - update documentation url to postman link
        return response()->json([
            "version"=>"0.1",
            "description"=>"This is the default landing of the API",
            "documentation"=>"https://laravel.com/docs/routing"
        ]);
    }
}
