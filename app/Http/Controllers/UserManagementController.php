<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{   
    //__construct
    private $menu_model;
    public function __construct()
    {
        $this->menu_model = new MenuModel();
    }

    public function index()
    {
        
        $data = array(
            'title' => 'User Management',
            'js' => '<script src="'.asset('/assets/js/page/user_management.js').'?_='.time().'"> </script>',
            'menu' => $this->menu_model->get_menu(),
        );

        return
        view('template/header', $data).
        view('user_management', $data).
        view('template/footer', $data);
    }

    public function datatable(Request $request)
    {
        //is ajax request
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        //get data
        $search = $request->search['value'];
        $query_search = "";
        if(!empty($search)){
            $query_search = "AND (
                                u.nama LIKE '%$search%' 
                                OR u.username LIKE '%$search%' 
                                )";
        }

        DB::enableQueryLog();

        $data = DB::table('users as u')
                ->select('u.id AS id_user', 'u.nama', 'u.username', 'u.status')
                ->whereRaw("1=1 $query_search");
                

        // dd(DB::getQueryLog());  
        //make datatable
        return Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function($row) {
            $btn = '';
            $btn_edit = '<a class="mt-1 me-2 btn btn-dim btn-outline-secondary btn-sm" onclick="reset_password_user('.$row->id_user.')"><em class="icon ni ni-edit"></em><span>Reset Password</span></a>';
            
            if($row->status == 1){
                $btn_user = '<a class=" mt-1 me-2 btn btn-dim btn-outline-danger btn-sm" onclick="delete_user('.$row->id_user.')"><em class="icon ni ni-trash"></em><span>Delete User</span></a>';
            }
            
            if($row->status == 0){
                $btn_user = '<a class=" mt-1 me-2 btn btn-dim btn-outline-success btn-sm" onclick="activate_user('.$row->id_user.')"><em class="icon ni ni-check-circle"></em><span>Activate User</span></a>';
            }

            $btn_menu = '<a class=" mt-1 me-2 btn btn-dim btn-outline-secondary btn-sm" onclick="menu_user('.$row->id_user.')"><em class="icon ni ni-list-index"></em><span>Setting Menu</span></a>';

            $btn = $btn_edit . $btn_user . $btn_menu;
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
       
    }

    public function activate_user(Request $request)
    {
        //is ajax request
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        //get data
        $id_user = $request->id_user ?? "";

        if(empty($id_user)){
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        //update data
        $update = DB::table('users')
                ->where('id', $id_user)
                ->update([
                    'status' => 1,
                ]);

        if($update){
            return response()->json(['status' => 'success', 'message' => 'User has been activated']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Failed to activate user']);
        }
    }

    public function delete_user(Request $request)
    {
        //is ajax request
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        //get data
        $id_user = $request->id_user ?? "";
        if(empty($id_user)){
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        //update data
        $update = DB::table('users')
                ->where('id', $id_user)
                ->update([
                    'status' => 0,
                ]);

        if($update){
            return response()->json(['status' => 'success', 'message' => 'User has been deleted']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Failed to delete user']);
        }
    }

    public function reset_password(Request $request)
    {
        //is ajax request
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        //get data
        $id_user = $request->id_user ?? "";
        if(empty($id_user)){
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        //update data
        
        $update = DB::table('users')
                ->where('id', $id_user)
                ->update([
                    'password' => "C07B69131BF83230D0D985A12F5B02E2", //jgn kasih tau 
                ]);

        if($update){
            return response()->json(['status' => 'success', 'message' => 'Password has been reset']);
        }else{
            return response()->json(['status' => 'error', 'message' => 'Failed to reset password']);
        }
    }

    public function process(Request $request)
    {
        //is ajax
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        $id_index_user = $request->id_index_user ?? "";
        
        $username = $request->username ?? "";
        $nama = $request->nama ?? "";
        $password = $request->password ?? "";
        $puskesmas = $request->puskesmas ?? "";

        //form validations using library

        $rules = [
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'password' => 'required|min:8',
        ];

        // Check if user_id is present (indicating an update)
        if ($request->has('id_index_user')) {
            $rules['username'] .= ',' . $id_index_user;
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }
        
        $password_enc = DB::select("SELECT enc_pass(?) AS password", [$password]);
        $password = $password_enc[0]->password;

        try {
            //code...
            if(($id_index_user != "")){
                //update data
                $update = DB::table('users')
                        ->where('id', $id_index_user)
                        ->update([
                            'username' => $username,
                            'nama' => $nama,
                            'password' => $password,
                            'puskesmas' => $puskesmas,
                        ]);
    
                if($update){
                    return response()->json(['status' => 'success', 'message' => 'User has been updated']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Failed to update user']);
                }
            }else{
                //insert data
                $insert = DB::table('users')
                        ->insert([
                            'username' => $username,
                            'nama' => $nama,
                            'password' => $password,
                            'status' => 1,
                            'puskesmas' => $puskesmas,
                        ]);
    
                if($insert){
                    return response()->json(['status' => 'success', 'message' => 'User has been added']);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Failed to add user']);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);

        }
    }

    public function get_data_menu_user(Request $request)
    {
       

        $id_index_user = $request->id_index_user ?? "";
        if(empty($id_index_user)){
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $data_user = DB::select("SELECT mm.nama AS nama_menu, mm.id AS id_menu, 
                                        u.nama AS nama_user, u.id AS id_user,
                                        mm.menu AS menu
                                FROM ms_menu mm 
                                JOIN tb_menu tm ON tm.menu  = mm.menu
                                JOIN users u ON u.id = tm.id_user
                                WHERE tm.id_user = ?", [$id_index_user]);
        
        $list_menu = DB::table('ms_menu')
                ->select('id', 'nama')
                ->get();

        $data = [
            'data_user' => $data_user,
            'list_menu' => $list_menu,
        ];

        
        return response()->json(['status' => 'success', 'data' => $data]);
        
    }

    public function process_menu_user(Request $request)
    {
        //is ajax
        if(!request()->ajax()){
            return response()->json(['status' => 'error', 'message' => 'Request not allowed'], 403);
        }

        $id_index_user = $request->id_index_menu_user ?? "";
        if(empty($id_index_user)){
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        //get data from db
        $list_menu = DB::table('ms_menu')
                ->select('id', 'nama', 'menu')
                ->get();

        try {
            //code...
            // $arr_menu = []; //untuk test saja
            foreach ($list_menu as $key => $value) {
                //find key value from request
                $menu = $value->menu;
                $hasil_menu = (string) $request->get($menu);

                

                if($hasil_menu != null && $hasil_menu == "1"){
                    //simpan di tb_menu menggunakan upsert



                    $insert = DB::table('tb_menu')
                            ->updateOrInsert(
                                ['id_user' => $id_index_user, 'menu' => $menu, 'status' => 1],
                                ['id_user' => $id_index_user, 'menu' => $menu, 'status' => 1]
                            );
                    
                }else{
                    //hapus menu
                    $delete = DB::table('tb_menu')
                            ->where('id_user', $id_index_user)
                            ->where('menu', $menu)
                            ->delete();
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Menu has been updated']);

        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return response()->json(['status' => 'error', 'message' => 'Failed to update menu']);
        }
    }
}


