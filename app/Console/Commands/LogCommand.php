<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Log;
use Auth;

class LogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:logcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate geolocation api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // ここに処理を記述
        //echo "Activate geolocation api!! \n";

        /** JavaScript出力開始 */
        echo <<<EOM
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
        //ユーザーの現在の位置情報を取得
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

        /***** ユーザーの現在の位置情報を取得 *****/
        function successCallback(position) {
            var gl_lat = "Lat:" + position.coords.latitude;
            var gl_lng = "Lng:" + position.coords.longitude;
            var accuracy = "Accuracy:" + position.coords.accuracy;

            var map = {"lat": gl_lat, "lng": gl_lng, "accuracy": accuracy};

            //ajaxで読み出し
            $.ajax({
                type: 'POST',
                url: '/',
                data: map,
            }).done(function(data){
                // ここに処理が完了したときのアクションを書く
                console.lgo("送信完了！\nレスポンスデータ：" + data);
            });
        }
        </script>
        EOM;

        /** JavaScript出力終了 */


        // $date = Carbon::now('Asia/Tokyo')->format('Y-m-d H:i:s');
        // $user_id = Auth::id();

        // print "<script language=javascript>hoge()</script>";

        // $lat = ;
        // $lng = ;

        // $log = new Log;
        // $log->user_id = $user_id;
        // $log->user_id = $date;
        // $log->origin_lat = $lat;
        // $log->origin_lng = $lng;
        // $log->save();
    }
};
