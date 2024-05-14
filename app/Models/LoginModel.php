<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class LoginModel extends Model
{
    function login($username = '', $password = ''){
        
        //Join Table tb_menu then Concat is to be array format
        $data = DB::table('users')
                ->leftjoin('tb_menu AS tm', 'tm.id_user', '=', 'users.id')
                ->leftjoin('ms_menu AS mm', 'mm.menu', '=', 'tm.menu')
                ->whereRaw('1=1')
                ->where('username', '=', $username)
                ->whereRaw('password = (SELECT enc_pass(?))', $password)
                ->selectRaw('users.*, GROUP_CONCAT(mm.route) AS menu')
                ->get()
                ->first();
        return $data;
    }

    public function getEnvHeader() {
        $env = env('APP_ENV');
        $data = DB::table('auth_token')
                    ->select('token', 'id_telp_wa', 'id_akun_wa')
                    ->where(['keterangan' => 'development', 'status' => 1])
                    // ->where(['keterangan' => $env, 'status' => 1])
                    ->first();
        
        // if(empty($data)){
        //     $data = DB::table('auth_token')
        //     ->select('token', 'id_telp_wa', 'id_akun_wa')
        //     ->where(['keterangan' => $env, 'status' => 1])
        //     ->first();
        // }

        return $data;   
    }
}
