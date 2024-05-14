<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function master_ruangan(Request $request)
    {   
        //create select2 data
        $page = $request->page ?? 1;
		$limit 	= $request->limit ?? 30;
		$start 	= ceil(($page - 1) * $limit);
        $search = $request->search;

        $puskesmas = session()->get('puskesmas');
        $data = DB::table('ms_ruang')
        ->where('kode_puskesmas', $puskesmas)
        ->where('status', '1')
        ->where(function($query) use ($search){
            $query->where('value', 'like', '%'.$search.'%')
            ->orWhere('nama', 'like', '%'.$search.'%');
        })
        ->select('value AS id', 'nama AS text' )
        ->selectRaw("COUNT(*) OVER() AS total")
        ->limit($limit)
        ->offset($start)
        ->get();
        
        $total = $data[0]->total;
        //remove all total from data
        $data = $data->map(function($item){
            unset($item->total);
            return $item;
        });

        $response = [
			'results' 		=> $data,
			'pagination' 	=> [
				'more' 		=> ($page * $limit) < $total
			]
		];

		// return as json for pagination in js
		return response()->json($response);
    }

    public function master_kendaraan(Request $request)
    {   
        $jenis = $request->jenis;
        $search = $request->search;

        $page = $request->page ?? 1;
        $limit 	= $request->limit ?? 30;
        $start 	= ceil(($page - 1) * $limit);

        //jika tidak ada jenis
        
        $data = DB::table('ms_kendaraan')
        ->where('status', '1')
        ->where(function($query) use ($search){
            $query->where('kode_kendaraan', 'like', '%'.$search.'%')
            ->orWhere('nama', 'like', '%'.$search.'%');
        })
        ->select('kode_kendaraan AS id', 'nama AS text' )
        ->selectRaw("COUNT(*) OVER() AS total");
        
        if(!empty($jenis)){
            $data = $data->where('tipe', $jenis);
        }

        $data = $data->limit($limit)
        ->offset($start)
        ->get();

        //jika data kosong
        if($data->isEmpty()){
            return response()->json([
                'results' => [],
                'pagination' => [
                    'more' => false
                ]
            ]);
        }

        //format ke select2
        $total = $data[0]->total;
        //remove all total from data

        $data = $data->map(function($item){
            unset($item->total);
            return $item;
        });

        $response = [
            'results' 		=> $data,
            'pagination' 	=> [
                'more' 		=> ($page * $limit) < $total
            ]
        ];

        // return as json for pagination in js
        return response()->json($response);    
    }

    public function master_puskesmas(Request $request) {
        $search = $request->search;

        $page = $request->page ?? 1;
        $limit 	= $request->limit ?? 30;
        $start 	= ceil(($page - 1) * $limit);

        //jika tidak ada jenis
        
        $data = DB::table('ms_puskesmas')
        ->where('status', '1')
        ->where(function($query) use ($search){
            $query->where('nama_puskesmas', 'like', '%'.$search.'%');
        })
        ->select('kode AS id', 'nama_puskesmas AS text' )
        ->selectRaw("COUNT(*) OVER() AS total");
      
        $data = $data->limit($limit)
        ->offset($start)
        ->get();

        //jika data kosong
        if($data->isEmpty()){
            return response()->json([
                'results' => [],
                'pagination' => [
                    'more' => false
                ]
            ]);
        }

        //format ke select2
        $total = $data[0]->total;
        //remove all total from data

        $data = $data->map(function($item){
            unset($item->total);
            return $item;
        });

        $response = [
            'results' 		=> $data,
            'pagination' 	=> [
                'more' 		=> ($page * $limit) < $total
            ]
        ];

        // return as json for pagination in js
        return response()->json($response);    

    }
}
