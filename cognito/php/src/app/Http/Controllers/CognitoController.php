<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cognito\CognitoClient;

class CognitoController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function signup(Request $request) 
    {
        app()->make(CognitoClient::class)->register($request->email, $request->password, $request->phone_number);
    }

    public static function callback()
    {
        return view('cognito.verify');
    }
}
