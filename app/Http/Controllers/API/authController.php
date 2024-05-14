<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//import DB
use Illuminate\Support\Facades\DB;
//import Validator
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\apiBaseController;

//Model
use App\Models\LoginModel;

class authController extends apiBaseController
{    
    private $login_model;
    function __construct()
    {
        $this->login_model = new LoginModel();
    }

    function check_auth(Request $request){
    
        $token = ($request->header('token', false));

        if($token == false){
            return $this->jsonGagal('Token tidak ditemukan', 401);
        }

        $user = DB::table('users')->where('_token', $token)
        ->select('id', 'nama', 'username', 'puskesmas', '_token')
        // ->selectRaw('dec_pass(password) as password')
        ->first();

        if($user == null){
           return $this->jsonGagal('Token invalid, login ulang', 401);
        }
        
        return $this->jsonBerhasil($user, 'Selamat Datang di Aplikasi MFK Puskesmas Kagok', 200);
    
    }

    function auth_login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $this->jsonGagal("Username dan password harus di isi", 400);
        }

        $username = $request->input('username');
        $password = $request->input('password');
        
        $user = $this->login_model->login($username, $password);

        if($user->username == null){
            return $this->jsonGagal('Username atau password salah', 401);
        }

        // dd($user);
        
        // create token 
        $token = md5($user->username . $user->password . time());
        
        //update to DB
        DB::table('users')->where('id', $user->id)
        ->update([
            '_token' => $token
        ]);
        
        //update token from $user
        $user->_token = $token;

        return $this->jsonBerhasil($user, 'Login berhasil. Selamat Datang di Aplikasi MFK Puskesmas Kagok', 200);
    }
}
