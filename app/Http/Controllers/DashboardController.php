<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\DashboardModel;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $menu_model;
    private $client;
    private $dashboard_model;
    function __construct()
    {
        $this->menu_model = new MenuModel();
        $this->dashboard_model = new DashboardModel();  
    }

    function index(Request $request)
    {

        //Get data from menu
        $tanggal = $request->get('tanggal') ?? date('Y-m-d');
        $data_mfk = $this->dashboard_model->data_dashboard($tanggal);

        $data = array(
            'title' => 'Dashboard',
            'js' => '<script src="'.asset('assets/js/page/dashboard.js').'">
                    </script><script src="'.asset('assets/js/charts/chart-ecommerce.js').'"></script>',
            'menu' => $this->menu_model->get_menu(),
            'data_mfk' => $data_mfk, 
        );

        return
        view('template/header', $data).
        view('dashboard', $data).
        view('template/footer', $data);
    }

    public function get_data_mfk(Request $request)
    {
        $tanggal = $request->get('tanggal_mfk') ?? date('d/m/Y');
        $tgl_input = Carbon::createFromFormat('d/m/Y', $tanggal);
        $tgl_input = $tgl_input->format('Y-m-d');
        $data_mfk = DashboardModel::data_dashboard($tgl_input);

        return response()->json($data_mfk);
    }

    public function changeTheme(Request $request) {
        $is_ajax = $request->ajax();

        if($is_ajax) {

            $id_user  = $request->session()->get('id_user');
            $old_data = DB::table('user')->where('id', $id_user)->first();
            $dark_mode = $old_data->dark_mode;

            // change theme
            if($dark_mode == 1) {
                DB::table('user')->where('id', $id_user)->update(['dark_mode' => '0']);
            } else {
                DB::table('user')->where('id', $id_user)->update(['dark_mode' => '1']);
            }
            
        } else {
            return abort('404');
        }
    }
    
    public function updateProfile(Request $request) {
        $is_ajax = $request->ajax();

        if($is_ajax) {

            $name = $request->post('name');
            $email = $request->post('email');
            $id_user = $request->session()->get('id_user');

            if($name != null && $email != null) {
                $update = DB::table('user')->where('id', $id_user)->update(['nama_agent' => $name, 'email' => $email]);

                if($update) {
                    $status = 1;
                    $message = 'Sukses update profile';
                } else {
                    $status = 0;
                    $message = 'Gagal update profile';
                }
    
            } else {
                $status = 0;
                $message = 'Gagal update profile';
            }
            
            return response()->json([
                'status'  => $status,
                'message' => $message
            ]);
            
        } else {
            return abort('404');
        }
    }

    public function change_password(Request $request) {
        $is_ajax = $request->ajax();

        if($is_ajax) {

            // validasi
            $validator = Validator::make($request->all(), [
                'current_password'  => 'required',
                'new_password'      => 'required',
                'confirm_password'  => 'required|same:new_password'
            ]);

            if($validator->stopOnFirstFailure()->fails()) {
                // failed
                $status  = 0;
                $message = 'Gagal change password !';    

            } else {
                // sukses validasi
                $id                  = $request->session()->get('id_user');
                $current_password    = $request->post('current_password');
                $new_password        = $request->post('new_password');
                $confirm_password    = $request->post('confirm_password');

                $data = DB::table('users')->where('id', $id)->first();


                // decoded current password
                $pass     = DB::select("SELECT enc_pass(?) as pw", [$current_password]);

                // check if data current password is correct
                if($data->password == $pass[0]->pw) {

                    // decoded new password
                    $newPass = DB::select("SELECT enc_pass(?) as pw", [$new_password]);
                    $newPass = $newPass[0]->pw;

                    $process = DB::table('users')->where('id', $id)->update(['password' => $newPass]);
    
                    $status  = 1;
                    $message = 'Sukses change password !';
                } else {
                    $status  = 0;
                    $message = 'Gagal change password !';
                }
            }

            $data = [
                'status'  => $status,
                'message' => $message
            ];

            return response()->json($data);

        } else {
            return abort('404');
        }
    }
}
