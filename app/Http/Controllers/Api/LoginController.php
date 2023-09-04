<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    public function login(){
        return view('Login.login');
    }
    public function loginApi(Request $request){

        $request->validate([
            'fty' => 'required',
            'wh' => 'required',
            'nik' => 'required',
            'pass' =>'required',
        ]);
       
        try{
        // $http = new \GuzzleHttp\Client;
        $fty =  $request->fty;
        $wh =  $request->wh;
        $nik =  $request->nik;
        $pass =  $request->pass;

           
             /* API URL */
                $url = 'http://192.168.100.190/api/api/v1.0/login';
                    
                /* Init cURL resource */
                $ch = curl_init($url);
                    
                /* Array Parameter Data */
                $data = [
                    'fty'=>$fty,
                    'wh' =>$wh, 
                    'nik'=>$nik,
                    'pass'=>$pass
                ];
                    
                /* pass encoded JSON string to the POST fields */
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    
                /* set the content type json */
                $headers = [];
                $headers[] = 'Content-Type:application/json';
                $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9ncmFtIjoid21zIn0.UgiKdlrIphDsq5vj5g5NYzjd_38NcLllXAX4xM_TIVM";
                $headers[] = "Authorization: Bearer ".$token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    
                /* set return type json */
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    
                /* execute request */
                $result = curl_exec($ch);
                    
                /* close cURL resource */
                curl_close($ch);
                return redirect('home');
            
        } 
        catch(\Exception $e){
                return redirect()->back()->with('error','Login fail, Please try again');
            }     
    } 
}
