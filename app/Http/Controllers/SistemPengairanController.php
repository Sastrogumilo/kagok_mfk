<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuModel;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SistemPengairanController extends Controller
{
    private $menu_model;
    function __construct()
    {
        $this->menu_model = new MenuModel();
    }

    public function index()
    {
        $data = array(
            'title' => 'Sistem Pengairan',
            'js'    => '<script src="'.asset('assets/js/page/sistem_pengairan.js').'"></script>',
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
        view("sistem_pengairan", $data).
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

       
        $query_search = "";
        if(!empty($search)){
            $query_search = "AND (
                                ta.keterangan LIKE '%$search%' 
                                OR ta.tindak_lanjut LIKE '%$search%' 
                                OR ta.ruang LIKE '%$search%'
                                )";
        }

        DB::enableQueryLog();
        $data = DB::table('tb_pengairan AS ta')
                ->whereRaw("1=1 $query_search")
                ->where('ta.status', "=", 1) 
                ->whereRaw("DATE(ta.tgl_input) BETWEEN DATE('$start_date') AND DATE('$end_date')")
                ->select('id',
                        'tgl_input', 
                        'ruang', 
                        'sumber_air',
                        'kran_air',
                        'kualitas_air',
                        'wastafel',
                        'keterangan',
                        'tindak_lanjut',
                        'insert_at', 
                        'insert_by',
                        'insert_by_id',
                        'update_at', 
                        'update_by', 
                        'status',
                        )
                    ->selectRaw('COUNT(*) OVER() AS total')
                    ;

        // dd($data);
        // dd(DB::getQueryLog());

        //Yajra format

        return Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function($row) {
            $btn = '';
            $btn_edit = '<a class="mt-1 me-2 btn btn-dim btn-outline-secondary btn-sm" onclick="edit_pengairan('.$row->id.')"><em class="icon ni ni-edit"></em><span>Edit</span></a>';
            $btn_delete = '<a class=" mt-1 me-2 btn btn-dim btn-outline-danger btn-sm" onclick="delete_pengairan('.$row->id.')"><em class="icon ni ni-trash"></em><span>Delete</span></a>';
            
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
        
        
        $tgl_input = Carbon::createFromFormat('d/m/Y', $data['tgl_input']);
        $data['tgl_input'] = $tgl_input->format('Y-m-d');
        //jika id_index_kelistrikan ada, maka update, jika ada maka insert
        
        try{

            if(!empty($data['id_index_pengairan'])){
                //update
                
                $update = DB::table('tb_pengairan')
                            ->where('id', $data['id_index_pengairan'])
                            ->update([
                                'tgl_input'     => $data['tgl_input'], //format 'Y-m-d
                                'ruang'         => $data['ruang'],
                                'sumber_air'    => $data['sumber_air'],
                                'kran_air'      => $data['kran_air'],
                                'kualitas_air'  => $data['kualitas_air'],
                                'wastafel'      => $data['wastafel'],
                                'keterangan'    => $data['keterangan'],
                                'tindak_lanjut' => $data['tindak_lanjut'],
                                'update_at'     => date('Y-m-d H:i:s'),
                                'update_by'     => session()->get('nama'),
                                'status'        => 1
                            ]);
            }else{

                //insert
                $insert = DB::table('tb_pengairan')
                            ->insert([
                                'tgl_input'     => $data['tgl_input'], //format 'Y-m-d
                                'ruang'         => $data['ruang'],
                                'sumber_air'    => $data['sumber_air'],
                                'kran_air'      => $data['kran_air'],
                                'kualitas_air'  => $data['kualitas_air'],
                                'wastafel'      => $data['wastafel'],
                                'keterangan'    => $data['keterangan'],
                                'tindak_lanjut' => $data['tindak_lanjut'],
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
        $update = DB::table('tb_pengairan')
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

        $data = DB::table('tb_pengairan')
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
