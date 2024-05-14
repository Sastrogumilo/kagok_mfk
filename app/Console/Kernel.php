<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\BroadcastController;
use App\Models\ConfigBEModel;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    private $broadcast;
    private $client;

    public $config_be;
    public $dashboard;

    protected function schedule(Schedule $schedule)
    {   
        $this->config_be = new ConfigBEModel();
        $data_config = $this->config_be->get_config();
        // $schedule->command('inspire')->hourly();
        $this->broadcast = new BroadcastController;
        $this->dashboard = new DashboardController;

        // Log::info('Scheduler minutes: '.$data_config->scheduler_minutes);
        $schedule->call(function() {
            $this->broadcast->eksekusi_pesan();
        })
        ->timezone('Asia/Jakarta')
        ->name('eksekusi_pesan')
        ->environments(['development', 'production'])
        ->everyMinute()
        ->when((intval(time()/60)) % $data_config->scheduler_minutes == 0)
        ->withoutOverlapping();

        // cron buat kalo agent ga aktif selama 1 jam, maka statusnya jadi not_available berdasarkan last chat agent
        $schedule->call(function() {
            $data = DB::table('user as u')->select('u.username', 'a.token', 'a.id_telp_wa', 'a.id_akun_wa')
                        ->join('auth_token as a', 'a.keterangan', '=', 'u.env')
                        ->where(['u.status_agent' => 'available', 'u.id_role' => 3, 'a.status' => 1])
                        ->get();

            $this->client       = new Client([
                'base_uri' => env('APP_ENV') == 'development' ?  "http://192.168.20.100:6969/" : "https://wahook.nexagroup.id/",
                'timeout'  => 5.0,
            ]);
    
            foreach ($data as $d) {

                $headers = [
                    'secret'        => 'xmarmut.com/kucingpoi.care/cornhub.com',
                    'token-wa'      => $d->token,
                    'id-telp-wa'    => $d->id_telp_wa,
                    'id-akun-wa'    => $d->id_akun_wa
                ];

                $json = [
                    'user'      => $d->username,
                ];
        
                $res = $this->client->request('POST', 'chat/get_last_message_agent', ['headers' => $headers, 'json' => $json]);
                $res = json_decode($res->getBody(), FALSE)->response;

                if(count($res) > 0) {

                    $arr_user = $res[0]->users;
                    // cek kalau ada nomor 62 atau 0 dan internal_production
                    foreach ($arr_user as $key => $value) {
                        // Check if the first string contains the desired substrings
                        if (strpos($value, '62') !== false || strpos($value, '0') !== false || strpos($value, 'internal_production') !== false) {
                            unset($arr_user[$key]); // Remove the element from the array
                        }
                    }

                    // Re-index the array
                    $username = array_values($arr_user)[0];
                    $end    = $res[0]->end_timeout;
                    $now    = date('Y-m-d H:i:s', intval(microtime(true)));

                    if($now > $end) {
                        // set to not_available
                        $proses = DB::table('user')->where('username', $username)->update(['status_agent' => 'not_available']);
                    }
                    
                }

            }

        })
        ->timezone('Asia/Jakarta')
        ->name('status_cron')
        ->environments(['production'])
        ->hourly()
        ->withoutOverlapping();

        /**
         * Update:
         * 19 Januari 2024
         * Add cron job untuk menutup sesi 
         */
        $schedule->call(function() {
            $this->dashboard->execute_cron_tutup_sesi();
        })
        ->timezone('Asia/Jakarta')
        ->name('cron_tutup_sesi')
        ->environments(['production'])
        ->everyMinute()
        ->withoutOverlapping();
        ;   
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
