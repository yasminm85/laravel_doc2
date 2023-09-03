<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token   
        ], 200);
    }

    //login
    public function login(){
        return view('login');
    }
    public function loginApi(Request $request){

        $request->validate([
            'email' =>'required|email',
            'password' =>'required',
        ]);
        try{
            $http = new \GuzzleHttp\Client;
        $email =  $request->email;
        $password =  $request->password;

        $response = $http->post('http://localhost/laravel',[
            'header'=>[
                'Authorization'=>'Bearer'.session()->get('token.access_token')
            ],
            'query'=>[
                'email'=>$email,
                'password'=>$password
            ]
            ]);

            $result = json_decode((string)$response->getBody(),true);
            return dd($result);

            return redirect()->route('home');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Login fail, Please try again');
        }
        
    }
}
