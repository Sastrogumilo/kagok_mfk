<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuModel extends Model
{
    use HasFactory;
    function get_menu(){

        $id_user = session()->get('id_user');   


        $menu = DB::table('tb_menu AS tm')
                    ->join('ms_menu AS mm', 'tm.menu', '=', 'mm.menu')
                    ->where('tm.id_user', $id_user)
                    ->where('tm.status', 1)
                    ->where('mm.status', 1)
                    ->selectRaw('mm.*')
                    ->orderBy('mm.urutan', 'ASC')
                    ->get();

        $html_menu = '<li class="nk-menu-item">
                        <a href="/dashboard" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-server-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->';

        foreach ($menu as $key => $value) {
            /**  $value
            {
                "id": 1
                "nama": "APAR"
                "icon": "<em class="icon ni ni-shield-star-fill">"
                "route": "/apar"
                "status": 1
                "insert_at": "2024-03-02 09:54:43"
                "insert_by": "admin"
            }
             */

            $route = $value->route;
            $icon = $value->icon;
            $nama = $value->nama;
            
            $html_menu .= ' 
                    <li class="nk-menu-item">
                        <a href="'.$route.'" class="nk-menu-link">
                            <span class="nk-menu-icon">'.$icon.'</em></span>
                            <span class="nk-menu-text">'.$nama.'</span>
                        </a>
                    </li><!-- .nk-menu-item -->';
        }

       

        return $html_menu;
        
    }

    function get_menu_notif_mkf_raw(){

        $menu = DB::table('ms_menu AS mm')
                    ->where('mm.notif_mfk', 1)
                    ->selectRaw('mm.*, "0"AS jumlah')
                    ->orderBy('mm.urutan', 'ASC')
                    ->get();

        $menu = $menu->toArray();
        return $menu;
        
    }

    function get_menu_notif_mkf(){

        $menu = DB::table('tb_notifikasi_mfk AS tm')
                    ->join('ms_menu AS mm', 'tm.kode_menu', '=', 'mm.menu')
                    ->where('mm.notif_mfk', 1)
                    ->selectRaw('mm.*, tm.jumlah')
                    ->orderBy('mm.urutan', 'ASC')
                    ->get();
                
        $menu = $menu->toArray();   

        return $menu;
        
    }
}
