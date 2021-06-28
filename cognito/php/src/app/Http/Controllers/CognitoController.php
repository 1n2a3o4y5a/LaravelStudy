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
        $data = app()->make(CognitoClient::class)->register($request->email, $request->password, $request->phone_number);
        return redirect()->route('cognito.confirm')->with('data', $data);
    }

    public static function confirmView(Request $request) 
    {
        return view('cognito.confirm')->with('data', $request->session()->get('data'));
    }

    public static function confirm(Request $request) 
    {
        $res = app()->make(CognitoClient::class)->confirm($request);
    }

    public static function callback()
    {
        return view('cognito.success');
    }
}
