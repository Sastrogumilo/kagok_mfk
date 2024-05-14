<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Throwable;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    //          
    private $login_model;
    function __construct()
    {
        $this->login_model = new LoginModel();
    }

    function index(){
        $data = array(
            'title' => 'Login | WhatsApp Bussiness Management Application by Nexa',
            'js'    => '<script src="'.asset('assets/js/app/dashboard.js').'"></script>'
            /* 'js' => highchart()
                    .js_moment()
                    .js_counter()
                    .js_amchart()
                    .js_fullcalendar()
                    .js_bs_select(), */
            // 'javascript' =>  '<script src="'.asset('app.js').'"></script>'
        );
        return 
        // view("template/header", $data).
        view("login", $data);
    }

    function auth_login(Request $request){

        $username = $request->post('username');
        $password = $request->post('password');
        $now = date('Y-m-d');

        // validasi        
        $validator = Validator::make($request->all(), [
            'username'  => 'required',
            'password'  => 'required'
        ]);

        if($validator->fails()) {
            $result = array(
                'status'  => false, 
                'message' => 'Tolong periksa kembali isian anda !'
            );

        } else {
            $cek = $this->login_model->login($username, $password);

            $result = array(
                'status' => false, 
                'message' => 'Username atau Password anda salah. Periksa kembali isian anda !'
            );

            if(!empty($cek)) {

                // activation harus kurang dari sekarang
                // dd($cek);
                $sess_array = array(
                    'is_login'      => true,
                    'username'      => isset($cek->username) ? $cek->username : '',
                    'nama'          => $cek->nama,
                    'id_user'       => $cek->id,
                    'arr_menu'      => explode(",", $cek->menu) ,
                    'is_admin'      => $cek->is_admin,
                    'puskesmas'     => $cek->puskesmas,
                );

                //add /dashboard to arr_menu
                array_push($sess_array['arr_menu'], '/dashboard');
                array_push($sess_array['arr_menu'], '/');

                session()->put($sess_array);
                
                //Add token dari session ke DB
                $_token = session()->get('_token');
                $id_user = $cek->id;

                try{
                    DB::table('users')->whereRaw("id = '$id_user'")->update(['_token' => $_token]);

                }catch(Throwable $e){
                    dd($e);     
                }
              

                if (session()->get('username') == $username) {
                    $result = array(
                        'status' => true, 
                        'message' => 'Login Berhasil...'
                    );                   
                }
                
            }
        }

        if($request->ajax()) {
            return response()->json($result);
        } else {
            return abort(404);
        }

    }

    public function logout() 
    {
        // Delete token
        $id_user = session()->get('id_user');

        //session flush
        session()->flush();
        return redirect('/login');
    }

}
