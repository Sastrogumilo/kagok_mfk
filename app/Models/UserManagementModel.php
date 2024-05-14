<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserManagementModel extends Model
{

    function __construct() {

        $this->session = session();
        date_default_timezone_set("Asia/Jakarta");
        
    }

    function data_user_management($start = 0, $length = 0, $search = '', $column = '', $dir = '') {

        $list_searchabel_column = ['id', 'username'];
        $col_name               = isset($list_searchabel_column[$column]) ? $list_searchabel_column[$column] : 'id';

        $cari   = "AND u.username LIKE '%$search%'";
        $limit  = " LIMIT $start, $length";

        $sql = "SELECT u.*, mr.nama AS nama_role, GROUP_CONCAT(mg.nama_group SEPARATOR ', ') AS nama_group, mp.nama_perusahaan, COUNT(1) over() as total
                FROM `user` u
                LEFT JOIN ms_role mr ON mr.id = u.id_role
                LEFT JOIN tb_group_agent tga ON tga.id_user = u.id
                LEFT JOIN ms_group mg ON mg.id = tga.id_group
                LEFT JOIN ms_perusahaan mp ON mp.id = u.id_perusahaan 
                WHERE 1=1
                AND u.`status` = 1
                $cari
                GROUP BY u.id
                ORDER BY $col_name $dir
                $limit
            ";
                
        $data = DB::select($sql);
        
        return $data; 
    }

    public function process_user($id, $name, $username, $email, $perusahaan, $group, $role, $env = '') {

        DB::beginTransaction();

        try {

            $data_user = array(
                'nama_agent'    => $name,
                'username'      => $username,
                'email'         => $email,
                'id_perusahaan' => $perusahaan,
                'id_role'       => $role
            );

            if($id == null) {
                // insert data

                $user_key = generateRandomString(6);
        
                $data_user['user_key']  = $user_key;
                $default_password       = 'NM23OK!';
                $pass                   = DB::select("SELECT HEX(AES_ENCRYPT('$default_password', '$user_key')) AS pw FROM user");
                $data_user['password']  = $pass[0]->pw;
                $data_user['insert_at'] = date('Y-m-d H:i:s');
                $data_user['insert_by'] = $this->session->get('username');
                $data_user['env']       = $env;

                // insert to table user
                $id = DB::table('user')->insertGetId($data_user);

            } else {
                // update data

                DB::table('user')->where('id', $id)->update($data_user);

            }

            // delete existing data with same id
            DB::table('tb_group_agent')->where('id_user', $id)->delete();

            // insert to table tb_group_agent
            foreach($group as $g) {
                $data_group = [
                    'id_user'   => $id,
                    'id_group'  => $g,
                    'insert_at' => date('Y-m-d H:i:s'),
                    'insert_by' => $this->session->get('username')
                ];

                DB::table('tb_group_agent')->insert($data_group);
            }

            DB::commit();
            return 1;

        } catch(\Throwable $th) {
            dd($th);
            DB::rollback();
            return 0;
        }
    }

    public function reset_user($id) {

        DB::beginTransaction();

        try {

            // proses table user
            $data_user = DB::table('user')->where('id', $id)->first();

            if($data_user) {
                
                $default_password       = 'NM23OK!';
                $pass                   = DB::select("SELECT HEX(AES_ENCRYPT('$default_password', '$data_user->user_key')) AS pw FROM user");
                $data                   = ['password' => $pass[0]->pw];
                $process                = DB::table('user')->where('id', $id)->update($data);

                if($process) {
                    DB::commit();
                    return 1;
                } else {
                    DB::rollback();
                    return 0; 
                }
                
            } else {
                DB::rollback();
                return 0;
            }           

        } catch(\Throwable $th) {
            DB::rollback();
            return 0;
        }
    }

    public function delete_user($id) {

        DB::beginTransaction();

        try {

            // proses table user
            $data_user = ['status' => 9];
            DB::table('user')->where('id', $id)->update($data_user);

            // proses table tb_group_agent
            DB::table('tb_group_agent')->where('id_user', $id)->delete();

            DB::commit();
            return 1;

        } catch(\Throwable $th) {
            DB::rollback();
            return 0;
        }
    }
}
