<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;


class AparController extends apiBaseController
{
    //
    public function datatable(Request $request)
    {

        // dd($request->all());
        $data_user = json_decode($request->header('data_user'));

        //carbon format
        $start_date = $request->start_date ?? date('Y-m-01');
        // $start_date = Carbon::createFromFormat('d/m/Y', $start_date);
        // $start_date = $start_date->format('Y-m-d');
        

        $end_date = $request->end_date ?? date('Y-m-t');
        // $end_date = Carbon::createFromFormat('d/m/Y', $end_date);
        // $end_date = $end_date->format('Y-m-t');

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $search = $request->search['value'] ?? "";

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
                    ->selectRaw('DATE_FORMAT(tgl_input, "%d %M %Y") AS tgl_input')
                    ->selectRaw('IFNULL(DATE_FORMAT(tgl_kedaluwarsa, "%d %M %Y"), NULL) AS tgl_kedaluwarsa');

        // dd($data);
        // dd(DB::getQueryLog());

        //Yajra format

        $hasil = Datatables::of($data)->addIndexColumn()
        ->addColumn('action', function($row) use ($data_user){
            $btn = [];
            $btn_edit = 'edit';
            $btn_delete = 'delete';
            if($data_user->id == $row->insert_by_id){
                $btn[] = $btn_edit;
                $btn[] = $btn_delete; 
            }else if($data_user->is_admin == 1){
                $btn[] = $btn_edit;
                $btn[] = $btn_delete;
            }
            
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
        
        return $this->jsonBerhasil($hasil->original, 'Data berhasil diambil', 200);
   
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

        //sanitize input
        $validator = Validator::make($data, [
            'no_apar'       => 'required',
            'lokasi'        => 'required',
            'jenis_apar'    => 'required',
            'tgl_input'     => 'required',
            'selang'        => 'required',
            'pin'           => 'required',
            'isi_tabung'    => 'required',
            'handle_apar'   => 'required',
            'tekanan_gas'   => 'required',
            'corong_bawah'  => 'required',
            'kebersihan'    => 'required',
        ]);

        if($validator->fails()){
            $result = [
                'response' => $validator->errors()->first(),
                'metadata' => [
                    'status' => 400,
                    'message' => $validator->errors()->first(),
                ]
            ];
            return response()->json($result, 400);
        }

        $data_user = json_decode($request->header('data_user'));

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
                                'update_by'     => $data_user->nama,
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
                                'insert_by_id'  => $data_user->id,
                                'insert_by'     => $data_user->nama,
                                'status'        => 1
                            ]);

            }
    
    
            $result = [
                'response' =>  ['message' => 'Data berhasil disimpan'],
                'metadata' => [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ]
            ];
            return response()->json($result);

        }catch(\Exception $e){
            $result = [
                'response' => $e->getMessage(),
                'metadata' => [
                    'status' => 400,
                    'message' => $e->getMessage()
                ]
            ];
            return response()->json($result);
        }
    }

    public function hapus(Request $request)
    {
        $id = $request->id ?? "";

        if(empty($id)){
            $result = [
                'response' => ['message' => 'ID tidak boleh kosong'],
                'metadata' => [
                    'status' => 400,
                    'message' => 'ID tidak boleh kosong'
                ]
            ];
            return response()->json($result, 400);
        }

        //update status menjadi 0
        $update = DB::table('tb_apar')
                    ->where('id', $id)
                    ->update([
                        'status' => 0
                    ]);

        return response()->json([
            'response' => ['message' => 'Data berhasil dihapus'],
            'metadata' => [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]       
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
