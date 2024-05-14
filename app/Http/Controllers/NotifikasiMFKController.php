<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotifikasiMFKController extends Controller
{
    
    private $menu_model;
    function __construct()
    {
        $this->menu_model = new MenuModel();
    }

    public function index()
    {

        $data_menu = $this->menu_model->get_menu_notif_mkf();
        $data_menu_raw = $this->menu_model->get_menu_notif_mkf_raw();   

        // dd($data_menu_raw, $data_menu);
        //find the different from data_menu and data_menu_raw, 
        //if there is a different, then insert the new data to data_manu
        // Extract values from objects in array 1
        $value_data_menu_raw = array_map(function($obj) {
            return $obj->menu;
        }, $data_menu_raw);

        // Extract values from objects in array 2
        $value_data_menu = array_map(function($obj) {
            return $obj->menu;
        }, $data_menu);

        // Compute the difference between values arrays
        $difference = array_diff($value_data_menu_raw, $value_data_menu);

        // Filter array 1 based on the difference
        $result = array_filter($data_menu_raw, function($obj) use ($difference) {
            return in_array($obj->menu, $difference);
        });

        //add  result object to data_menu Object
        foreach($result as $key => $value){
            $data_menu[] = $value;
        }
    
        $data = array(
            'title' => 'Setting Notifikasi MFK',
            'js'    => '<script src="'.asset('assets/js/page/notif_mfk.js').'"></script>',
            /* 'js' => highchart()
                    .js_moment()
                    .js_counter()
                    .js_amchart()
                    .js_fullcalendar()
                    .js_bs_select(), */
            // 'javascript' =>  '<script src="'.asset('app.js').'"></script>'
            'menu' => $this->menu_model->get_menu(),
            'data_menu_mfk' => $data_menu,
        );
        return 
        // view("template/header", $data).
        
        view('template.header', $data).
        view("notif_mfk", $data).
        view('template.footer', $data);
    }

    public function process(Request $request)
    {
        
        $data = $request->all();

        /**
         [ 
            "apar" => "10"
            "ipal" => "0"
            "gas_medik" => "0"
            "sistem_kelistrikan" => "0"
            "sistem_pengairan" => "0"
            "sistem_jaringan_komunikasi" => "0"
            "sistem_proteksi_petir" => "0"
            "pagar_selasar" => "0"
            "pencahayaan_dan_ventilasi" => "0"
            "kendaraan_puskesmas" => "0"
            "mobil_pusling" => "0"
        ]
         */
        
        try{
                //create upsert to tb_nofitikasi_mfk
                $puskesmas = session()->get('puskesmas');
                $nama = session()->get('nama');

                $data_upsert = [];
                foreach ($data as $key => $value) {
                    $data_upsert[] = [
                        'kode_puskesmas' => $puskesmas,
                        'kode_menu' => $key,
                        'jumlah' => $value,
                        'insert_by' => $nama,
                        'insert_at' => Carbon::now()
                    ];
                }
                
                //update or insert based on kode_puskesmas and kode_menu
                foreach ($data_upsert as $key => $value) {
                    # code...
                    
                    $insert = DB::table('tb_notifikasi_mfk')
                            ->updateOrInsert(
                                ['kode_puskesmas' => $puskesmas,
                                'kode_menu' => $value['kode_menu']],
                                [
                                    'kode_puskesmas' => $puskesmas, // 'kode_puskesmas' => '1
                                    'kode_menu' => $value['kode_menu'],
                                    'jumlah' => $value['jumlah'],
                                    'insert_by' => $value['insert_by'],
                                    'insert_at' => $value['insert_at']
                                ]
                            );
                }
                
                $result = [
                    'status' => true,
                    'message' => 'Data berhasil disimpan'
                ];
                return response()->json($result);

        }catch(\Exception $e){
            dd($e);
            $result = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return response()->json($result);
        }
    }
}
