<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class AparController extends Controller
{
    //
    private $menu_model;
    function __construct()
    {
        $this->menu_model = new MenuModel();
    }

    public function index()
    {
        $data = array(
            'title' => 'APAR',
            'js'    => '<script src="'.asset('assets/js/page/apar.js').'"></script>',
            /* 'js' => highchart()
                    .js_moment()
                    .js_counter()
                    .js_amchart()
                    .js_fullcalendar()
                    .js_bs_select(), */
            // 'javascript' =>  '<script src="'.asset('app.js').'"></script>'
            'menu' => $this->menu_model->get_menu()
        );
        return 
        // view("template/header", $data).
        
        view('template.header', $data).
        view("apar", $data).
        view('template.footer', $data);
    }

    public function datatable(Request $request)
    {

        // dd($request->all());

        //carbon format
        $start_date = $request->start_date ?? date('01/m/Y');
        $start_date = Carbon::createFromFormat('d/m/Y', $start_date);
        $start_date = $start_date->format('Y-m-d');
        
        $end_date = $request->end_date ?? date('t/m/Y');
        $end_date = Carbon::createFromFormat('d/m/Y', $end_date);
        $end_date = $end_date->format('Y-m-t');

        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];

        /**
         * Selected data
        {data: 'no_apar',           name: 'ta.no_apar'},
        {data: 'lokasi',            name: 'ta.lokasi'},
        {data: 'jenis_apar',        name: 'ta.jenis_apar'},
        {data: 'tgl_kedaluwarsa',   name: 'ta.tgl_kedaluwarsa'},
        {data: 'kapasitas',         name: 'ta.kapasitas'},
        {data: 'selang',            name: 'ta.selang'},
        {data: 'pin',               name: 'ta.pin'},
        {data: 'isi_tabung',        name: 'ta.isi_tabung'},
        {data: 'handle_apar',       name: 'ta.handle_apar'},
        {data: 'tekanan_gas',       name: 'ta.tekanan_gas'},
        {data: 'corong_bawah',      name: 'ta.corong_bawah'},
        {data: 'kebersihan',        name: 'ta.kebersihan'},
        {data: 'insert_at',         name: 'ta.insert_at'},
        {data: 'insert_by',         name: 'ta.insert_by'},
        {data: 'update_at',         name: 'ta.update_at'},
        {data: 'update_by',         name: 'ta.update_by'},
        {data: 'status',            name: 'ta.status'},
         */
        $query_search = "";
        if(!empty($search)){
            $query_search = "AND (
                                ta.no_apar LIKE '%$search%' 
                                OR ta.lokasi LIKE '%$search%' 
                                OR ta.jenis LIKE '%$search%'  
                                OR ta.kapasitas LIKE '%$search%'  
                                )";
        }

        DB::enableQueryLog();
        $data = DB::table('tb_apar AS ta')
                ->whereRaw("1=1 $query_search")
                ->where('ta.status', "=", 1) 
                ->whereRaw("DATE(ta.tgl_input) BETWEEN DATE('$start_date') AND DATE('$end_date')")
                ->select('id',
                        'no_apar', 
                        'lokasi', 
                        'jenis AS jenis_apar', 
                        'tgl_input', 
                        'kapasitas', 
                        'selang', 
                        'pin', 
                        'isi_tabung', 
                        'handle_apar', 
                        'tekanan_gas', 
                        'corong_bawah', 
                        'kebersihan', 
                        'insert_at', 
                        'insert_by',
                        'insert_by_id',
                        'update_at', 
                        'update_by', 
                        'status',
                        )
                    ->selectRaw('COUNT(*) OVER() AS total')
                    ->selectRaw('IFNULL(tgl_kedaluwarsa, NULL) AS tgl_kedaluwarsa');

        // dd($data);
        // dd(DB::getQueryLog());

        //Yajra format

        return Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function($row) {
            $btn = '';
            $btn_edit = '<a class="mt-1 me-2 btn btn-dim btn-outline-secondary btn-sm" onclick="edit_apar('.$row->id.')"><em class="icon ni ni-edit"></em><span>Edit</span></a>';
            $btn_delete = '<a class=" mt-1 me-2 btn btn-dim btn-outline-danger btn-sm" onclick="delete_apar('.$row->id.')"><em class="icon ni ni-trash"></em><span>Delete</span></a>';
            
            if(session()->get('id_user') == $row->insert_by_id){
                $btn = $btn_edit . $btn_delete;
            }else if(session()->get('is_admin') == 1){
                $btn = $btn_edit . $btn_delete;
            }
            
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);

        
    }

    public function process(Request $request)
    {
        
        $data = $request->all();
        
        if($data['tgl_kedaluwarsa'] != ''){
            $tgl_kedaluwarsa = Carbon::createFromFormat('d/m/Y', $data['tgl_kedaluwarsa']);            
            $data['tgl_kedaluwarsa'] = $tgl_kedaluwarsa->format('Y-m-d');
        }else{
            $data['tgl_kedaluwarsa'] = null;
        }
        
        $tgl_input = Carbon::createFromFormat('d/m/Y', $data['tgl_input']);
        $data['tgl_input'] = $tgl_input->format('Y-m-d');
        //jika id_index_apar ada, maka update, jika ada maka insert
        

        try{

            if(!empty($data['id_index_apar'])){
                //update
                
                $update = DB::table('tb_apar')
                            ->where('id', $data['id_index_apar'])
                            ->update([
                                'no_apar'       => $data['no_apar'],
                                'lokasi'        => $data['lokasi'],
                                'jenis'         => $data['jenis_apar'],
                                'tgl_kedaluwarsa' => $data['tgl_kedaluwarsa'],
                                'tgl_input'     => $data['tgl_input'], //format 'Y-m-d
                                'kapasitas'     => $data['kapasitas'],
                                'selang'        => $data['selang'],
                                'pin'           => $data['pin'],
                                'isi_tabung'    => $data['isi_tabung'],
                                'handle_apar'   => $data['handle_apar'],
                                'tekanan_gas'   => $data['tekanan_gas'],
                                'corong_bawah'  => $data['corong_bawah'],
                                'kebersihan'    => $data['kebersihan'],
                                'update_at'     => date('Y-m-d H:i:s'),
                                'update_by'     => session()->get('nama'),
                                'status'        => 1
                            ]);
            }else{

                //insert
                $insert = DB::table('tb_apar')
                            ->insert([
                                'no_apar'       => $data['no_apar'],
                                'lokasi'        => $data['lokasi'],
                                'jenis'         => $data['jenis_apar'],
                                'tgl_kedaluwarsa' => $data['tgl_kedaluwarsa'],
                                'tgl_input'     => $data['tgl_input'],
                                'kapasitas'     => $data['kapasitas'],
                                'selang'        => $data['selang'],
                                'pin'           => $data['pin'],
                                'isi_tabung'    => $data['isi_tabung'],
                                'handle_apar'   => $data['handle_apar'],
                                'tekanan_gas'   => $data['tekanan_gas'],
                                'corong_bawah'  => $data['corong_bawah'],
                                'kebersihan'    => $data['kebersihan'],
                                'insert_at'     => date('Y-m-d H:i:s'),
                                'insert_by_id'  => session()->get('id_user'),
                                'insert_by'     => session()->get('nama'),
                                'status'        => 1
                            ]);

            }
    
    
            $result = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ];
            return response()->json($result);

        }catch(\Exception $e){
            $result = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return response()->json($result);
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id ?? "";

        if(empty($id)){
            $result = [
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ];
            return response()->json($result);
        }

        //update status menjadi 0
        $update = DB::table('tb_apar')
                    ->where('id', $id)
                    ->update([
                        'status' => 0
                    ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function get_data(Request $request)
    {
        $id = $request->id ?? "";
        if(empty($id)){
            $result = [
                'status' => 'error',
                'message' => 'ID tidak ditemukan'
            ];
            return response()->json($result);
        }

        $data = DB::table('tb_apar')
                ->where('id', $id)
                ->where('status', 1)
                ->first();

        if(empty($data)){
            $result = [
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ];
            return response()->json($result);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
