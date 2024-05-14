<?php 

use Illuminate\Support\Facades\DB;
use Http\Client\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\GuzzleException;

// function checkLevel($id = '') {
// 	$level = session()->get('level');
// 	if(!empty($id)) {
// 		$levelAccess = DB::table('menu')->where('id_menu', $id)->first();
// 		if($level <= $levelAccess->user) {
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	} else {
// 		return false;
// 	}
// }

function ini_rahasia() 
{
	return 'xmarmut.com/kucingpoi.care/cornhub.com';
}

if ( ! function_exists('_parse_form_attributes'))
{
	/**
	 * Parse the form attributes
	 *
	 * Helper function used by some of the form helpers
	 *
	 * @param	array	$attributes	List of attributes
	 * @param	array	$default	Default values
	 * @return	string
	 */
	function _parse_form_attributes($attributes, $default)
	{
		if (is_array($attributes))
		{
			foreach ($default as $key => $val)
			{
				if (isset($attributes[$key]))
				{
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}

			if (count($attributes) > 0)
			{
				$default = array_merge($default, $attributes);
			}
		}

		$att = '';

		foreach ($default as $key => $val)
		{
			if ($key === 'value')
			{
				$val = sanitasi_char($val);
			}
			elseif ($key === 'name' && ! strlen($default['name']))
			{
				continue;
			}

			$att .= $key.'="'.$val.'" ';
		}

		return $att;
	}
}

if ( ! function_exists('_attributes_to_string'))
{
	/**
	 * Attributes To String
	 *
	 * Helper function used by some of the form helpers
	 *
	 * @param	mixed
	 * @return	string
	 */
	function _attributes_to_string($attributes)
	{
		if (empty($attributes))
		{
			return '';
		}

		if (is_object($attributes))
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes))
		{
			$atts = '';

			foreach ($attributes as $key => $val)
			{
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		return FALSE;
	}
}

function sanitasi_char($str){
    $res = preg_replace('/[0-9\@\.\;\" "\']+/', '', $str);
    return $res;
}

function sanitasi_input($str) {
    $res = preg_replace('/[\;\" "\']+/', '', $str);
    return $res;
}

if ( ! function_exists('form_dropdown'))
{
	/**
	 * Drop-down Menu
	 *
	 * @param	mixed	$data
	 * @param	mixed	$options
	 * @param	mixed	$selected
	 * @param	mixed	$extra
	 * @return	string
	 */
	function form_dropdown($data = '', $options = array(), $selected = array(), $extra = '')
	{
		$defaults = array();

		if (is_array($data))
		{
			if (isset($data['selected']))
			{
				$selected = $data['selected'];
				unset($data['selected']); // select tags don't have a selected attribute
			}

			if (isset($data['options']))
			{
				$options = $data['options'];
				unset($data['options']); // select tags don't use an options attribute
			}
		}
		else
		{
			$defaults = array('name' => $data);
		}

		is_array($selected) OR $selected = array($selected);
		is_array($options) OR $options = array($options);
		// If no selected state was submitted we will attempt to set it automatically
		if (empty($selected))
		{
			if (is_array($data))
			{
				if (isset($data['name'], $_POST[$data['name']]))
				{
					$selected = array($_POST[$data['name']]);
				}
			}
			elseif (isset($_POST[$data]))
			{
				$selected = array($_POST[$data]);
			}
		}

		$extra = _attributes_to_string($extra);

		$multiple = (count($selected) > 1 && stripos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";
		foreach ($options as $key => $val)
		{
			$key = (string) $key;
			if (is_array($val))
			{
				if (empty($val))
				{
					continue;
				}

				$form .= '<optgroup label="'.$key."\">\n";
				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
					$form .= '<option value="'.sanitasi_char($optgroup_key).'"'.$sel.'>'
						.(string) $optgroup_val."</option>\n";
				}

				$form .= "</optgroup>\n";
			}
			else
			{
				$form .= '<option value="'.$key.'"'
					.(in_array($key, $selected) ? ' selected="selected"' : '').'>'
					.(string) $val."</option>\n";
			}
		}

		return $form."</select>\n";
	}
}



function base_asset($base_url = '') {
    return (env('APP_ENV') == 'development') ? asset($base_url) : secure_asset($base_url);
}

function base_url($base_url = '') {
    return (env('APP_ENV') == 'development') ? url($base_url) : secure_url($base_url);
}

function js_datatable() {
	return '<script src="'.base_asset('assets/plugins/datatables/datatables.min.js').'" type="text/javascript"></script>';
}

function jsonBerhasil($data = []){
	return response()->json($data, 200);
}

function jsonGagal($data = []){
	return response()->json($data, 400);
}

function jsonNotFound(){
	return response()->json(["message" => "Data tidak ditemukan"], 404);
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function convertTanggal($tgl = '') {
	// terima format dd/mm/yyyy
	$tgl = str_replace('/', '-', $tgl);

	return date('Y-m-d', strtotime($tgl));
}

function uniqueCheck($table = '', $key = '', $param = '', $condition = ''){
	$sql = "SELECT id FROM `$table` WHERE `$key` = '$param' $condition";

	return collect(DB::select($sql))->first();
	
}

function current_session()
{
	return json_encode(session()->all());
}

function current_session_hex()
{
	
	$session = [
		'env' 			=> session()->get('env'),
		'id_group' 		=> session()->get('id_group'),
		'id_perusahaan' => session()->get('id_perusahaan'),
		'id_user' 		=> session()->get('id_user'),
		'id_role' 		=> session()->get('id_role'),
		'nama_agent' 	=> session()->get('nama_agent'),
		'nama_group' 	=> session()->get('nama_group'),
		'username' 		=> session()->get('username'),
		'erp' 			=> session()->get('erp'),
		'email' 		=> session()->get('email'),
		'ringtone'		=> session()->get('ringtone'),
	];

	return bin2hex(json_encode($session));
}

// function current_session_chat()
// {
// 	$id_user 	= session()->get('id_user');
// 	$id_group 	= session()->get('id_role');
// 	$rahasia 	= ini_rahasia();

//         $sql_get_current_session = "SELECT sc.*, c.telp_client, c.profile_name AS client_profile_name, 
// 									u.username, u.nama_agent AS sender_name, mg.nama_group, '$id_user' AS current_user_id,
// 									'$rahasia' AS rahasia, c.id_session
// 									FROM nexa_wahook.session_chat sc
// 									JOIN client c ON c.id = sc.id_client
// 									LEFT JOIN `user` u ON u.id = sc.id_user 
// 									JOIN nexa_wahook.ms_group mg ON mg.id = sc.id_group
// 									WHERE 1=1 
// 									-- AND sc.end IS NULL 
// 									AND (sc.id_user = '$id_user' OR sc.id_user IS NULL)
// 									AND sc.end IS NULL
// 									AND sc.status = 2
// 									ORDER BY id_user DESC 
// 									LIMIT 1
// 		";
		
// 		$hasil = isset(DB::select($sql_get_current_session)[0]) ? json_encode(DB::select($sql_get_current_session)[0]) : json_encode(array("pesan" => "Tidak ada session"));

// 		$data_session = bin2hex($hasil);

//         return $data_session;
// }


function random_string($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function get_counter($kode)
{
	$data = DB::table('ms_counter')->where('kode', $kode)->first();

	if(!empty($data)){
		$set_no = (int) $data->counter + 1;
		if(strlen($set_no) <= 3) {
			if (strlen($set_no) == 1) {
				$counter = "000" . $set_no;
			} elseif (strlen($set_no) == 2) {
				$counter = "00" . $set_no;
			} elseif (strlen($set_no) == 3) {
				$counter = "0" . $set_no;
			}
		} else {
			$counter = $set_no;
		}
	}else{
		$counter = '0001';
	}

	return $counter;
}

function host_wahook() {
	$url = 'https://wahook.nexagroup.id/';
	return $url;
}

function token_wahook() {
	$token = DB::table('auth_token')->first();
	return $token;
}

function upload_file($val, $name)
{	
	$response = Http::attach(
		'file', file_get_contents($val), $name
	)->post("https://aset.nexa.net.id/upload/nexamessenger");

	$result = $response->body();
	$parse = json_decode($result);

	return $parse;
}


