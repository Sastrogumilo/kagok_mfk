<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MainModel extends Model
{
    use HasFactory;
    public static function process_data($table = '', $data = [], $condition = '')
    {
        
        if ($condition) {
            // returns the number of affected rows if success
            $update = DB::table($table)->whereRaw($condition)->update($data);
            return $update;
        } else {
            // returns true or false
            $insert = DB::table($table)->insert($data);
            return $insert;
        }
    }

}
