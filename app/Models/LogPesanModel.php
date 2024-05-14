<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\Request;
use Carbon;


class LogPesanModel extends Model
{   

    function __construct()
    {
        $this->client       = new Client([
            'base_uri' => env('APP_ENV') == 'development' ?  "http://192.168.20.100:6969/" : "https://wahook.nexagroup.id/",
            'timeout'  => 30.0,
        ]);
    }

    public function get_log_pesan($token, $idtlp, $idwa, $tanggal_awal, $tanggal_akhir, $search = "")
    {   

        $json = '{
            "start" : "'.$tanggal_awal.'",
            "end"   : "'.$tanggal_akhir.'"
        }';

        try {
    
            //Kenapa pake curl? karena guzzlehttp nggak bisa!,... bangsat
            $host = env('APP_ENV') == 'development' ?  "http://192.168.20.100:6969/" : "http://wahook.nexagroup.id/";
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $host.'panel/log_pesan'."?start=".$tanggal_awal."&end=".$tanggal_akhir."&search=".$search,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$json,
            CURLOPT_HTTPHEADER => array(
                'secret: xmarmut.com/kucingpoi.care/cornhub.com',
                'token-wa: '.$token,
                'id-telp-wa: '.$idtlp,
                'id-akun-wa: '.$idwa,
                'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return json_decode($response);

        } catch(\Throwable $err) {
            dd($err);
        }
    }
}
