<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DashboardModel extends Model
{
    use HasFactory;
    public static function data_dashboard($tanggal)
    {
        $data_menu = DB::select("SELECT mm.*, tnm.jumlah FROM tb_notifikasi_mfk tnm 
        JOIN ms_menu mm ON mm.menu = tnm.kode_menu 
                        AND mm.notif_mfk = 1 
                        AND mm.status = 1
        WHERE 1=1
        AND tnm.jumlah != 0");

        $query_union = "";

        foreach ($data_menu as $key => $value) {

            $menu = $value->menu;
            $nama = $value->nama;
            $icon = $value->icon;
            $db = $value->db;
            $jumlah = $value->jumlah;
            
            switch ($menu) {
                case 'ipal':
                    $query_union .= "SELECT '$nama' AS nama, 
                    '$jumlah' AS target_mfk, 
                    '$icon' AS icon,
                    COUNT(*) as total, 
                    CASE
                        WHEN COUNT(*) >= $jumlah THEN 'Sudah Terpenuhi'
                        ELSE 'Belum Terpenuhi'
                    END AS status_mfk
                    FROM (SELECT t.insert_at FROM $db t 
                    WHERE 1=1
                    AND t.status = 1
                    AND MONTH(t.tgl_input) = MONTH('$tanggal')  
                    AND YEAR(t.tgl_input) = YEAR('$tanggal')
                    GROUP BY t.insert_at ) AS item
                    
                    UNION
                    ";
                    break;
                case 'apar':
                    
                    $query_union .= "SELECT '$nama' AS nama, 
                    '$jumlah' AS target_mfk, 
                    '$icon' AS icon,
                    COUNT(*) AS total, 
                    CASE
                        WHEN COUNT(*) >= $jumlah THEN 'Sudah Terpenuhi'
                        ELSE 'Belum Terpenuhi'
                    END AS status_mfk
                    FROM (SELECT t.lokasi FROM $db t 
                    WHERE 1=1
                    AND t.status = 1
                    AND MONTH(t.tgl_input) = MONTH('$tanggal')  
                    AND YEAR(t.tgl_input) = YEAR('$tanggal')
                    GROUP BY t.lokasi ) AS item
                    
                    UNION
                    ";
                    break;

                    case 'mobil_pusling':
                    
                        $query_union .= "SELECT '$nama' AS nama, 
                        '$jumlah' AS target_mfk, 
                        '$icon' AS icon,
                        COUNT(*) AS total, 
                        CASE
                            WHEN COUNT(*) >= $jumlah THEN 'Sudah Terpenuhi'
                            ELSE 'Belum Terpenuhi'
                        END AS status_mfk
                        FROM (SELECT t.kode_kendaraan FROM $db t 
                        WHERE 1=1
                        AND t.status = 1
                        AND MONTH(t.tgl_input) = MONTH('$tanggal')  
                        AND YEAR(t.tgl_input) = YEAR('$tanggal')
                        GROUP BY t.kode_kendaraan ) AS item
                        
                        UNION
                        ";
                        break;

                        case 'kendaraan_puskesmas':
                    
                            $query_union .= "SELECT '$nama' AS nama, 
                            '$jumlah' AS target_mfk, 
                            '$icon' AS icon,
                            COUNT(*) AS total, 
                            CASE
                                WHEN COUNT(*) >= $jumlah THEN 'Sudah Terpenuhi'
                                ELSE 'Belum Terpenuhi'
                            END AS status_mfk
                            FROM (SELECT t.kode_kendaraan FROM $db t 
                            WHERE 1=1
                            AND t.status = 1
                            AND MONTH(t.tgl_input) = MONTH('$tanggal')  
                            AND YEAR(t.tgl_input) = YEAR('$tanggal')
                            GROUP BY t.kode_kendaraan ) AS item
                            
                            UNION
                            ";
                            break;
                default:
                    
                    $query_union .= "SELECT '$nama' AS nama, 
                    '$jumlah' AS target_mfk, 
                    '$icon' AS icon,
                    COUNT(*) as total, 
                    CASE
                        WHEN COUNT(*) >= $jumlah THEN 'Sudah Terpenuhi'
                        ELSE 'Belum Terpenuhi'
                    END AS status_mfk
                    FROM (SELECT t.ruang FROM $db t 
                    WHERE 1=1
                    AND t.status = 1
                    AND month(t.tgl_input) = MONTH('$tanggal')  
                    AND YEAR(t.tgl_input) = YEAR('$tanggal')
                    GROUP BY t.ruang ) AS item
                    
                    UNION
                    ";
                    break;
            }
        }

        //Remove last UNION

        if($query_union == "") {
            return array();
        }

        $query_union = preg_replace('/\bUNION\b(?=[^UNION]*$)/', '', $query_union);

        $data = DB::select($query_union);

        return $data;

    }
}
