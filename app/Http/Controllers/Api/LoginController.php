<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
    
            $fty =  $request->fty;
            $wh =  $request->wh;
            $nik =  $request->nik;
            $pass =  $request->pass;

            //inisialisasi dlu
            $curl = curl_init();

            //set urlnya
            curl_setopt($curl, CURLOPT_URL, 'http://192.168.100.190/api/api/v1.0/login');
            //method
            curl_setopt($curl, CURLOPT_POST, true);

            //requestnya ke bodynya
            $data = array(
                    'fty'=>$fty,
                    'wh' =>$wh, 
                    'nik'=>$nik,
                    'password'=>$pass,
                    'namaaplikasi'=>'wms'
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            //auth header
            $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9ncmFtIjoid21zIn0.UgiKdlrIphDsq5vj5g5NYzjd_38NcLllXAX4xM_TIVM";
            $headers = array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Accept: application/json'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            //memberikan return
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            //jalan execute
            $response = curl_exec($curl);
            
            //close
            curl_close($curl);
               
                
                $tampung = json_decode($response, true);
              
                if($tampung['success'] == true){
                    session(['autorize'=>true]);
                    return redirect('home');
                }else{
                    return back()->with('Loginerror','NIK atau Password Salah');
                }
                
                // var_dump(json_decode($response, true));
                // dd($tampung['success']);
                
            }

    
        
}







 








 
