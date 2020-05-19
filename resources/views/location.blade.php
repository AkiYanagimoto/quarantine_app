@extends('layouts.app')

@section('css')
{{-- この場所に画面毎のcssを記述する --}}
@endsection

@section('javascript-head')
{{-- この場所に画面毎(ヘッダ位置)のjsを記述する --}}
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
                
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <h2 class="text-center text-success" style="padding: 30px 0">SELF-QUARANTINE ??</h2>



            <button id="watch">Watch</button>
            <button id="stop_watch">Stop</button>
            <div id="statusArea2"></div>
            <div id="current_lat"></div>
            <div id="current_lng"></div>
            <div id="result"></div>
            



            <!-- ボタン -->
            <div class="container mb-5">
                <div class="col">
                    <div id="prof_section" class="btn_section">
                        <p class="text-center">Please update your profile first.</p>
                        <a href="{{ url('profile/'.$profile->id.'/edit', $is_production) }}" class="btn btn-success btn-lg btn-block" id="profile_btn" >
                                {{ __('EDIT YOUR PROFILE') }}</a>
                    </div>
                    <div id="getlog_section" class="btn_section">
                        <button type="button" class="btn btn-success btn-lg btn-block" name="get_log" id="get_log" >KEEP A LOG</button>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- フォーム -->
                    {{-- <form action="{{ url('homes') }}" method="POST" class="form-horizontal"> --}}
                        {{-- {{ csrf_field() }} --}}

                    <form action="{{ url('/home',$is_production) }}" method="post">
                        @csrf
           
                        <div class="form-group">
                            <!-- LATITUDE HOME -->
                            <div class="row">
                                <div class="col-form-label col-sm-6 text-center ">
                                    <label for="origin_lat" class="control-label">HOME (lat)</label>
                                </div>
                                <div class="col">
                                    <input type="number" name="origin_lat" id="origin_lat" class="form-control" value="{{$profile->origin_lat}}" readonly>
                                </div>
                            </div>
                            <!-- LONGITUDE HOME-->
                            <div class="row mb-4">
                                <div class="col-form-label col-sm-6 text-center ">
                                    <label for="origin_lng" class="control-label">HOME (lng)</label>
                                </div>
                                <div class="col">
                                    <input type="number" name="origin_lng" id="origin_lng" class="form-control" value="{{$profile->origin_lng}}" readonly>
                                </div>
                            </div>
                            <!-- LATITUDE NOW-->
                            <div class="row">
                                <div class="col-form-label col-sm-6 text-center ">
                                    <label for="current_lat" class="control-label">CURRENT PLACE (lat)</label>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.00000001" name="current_lat" id="current_lat" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- LONGITUDE NOW-->
                            <div class="row mb-4">
                                <div class="col-form-label col-sm-6 text-center ">
                                    <label for="current_lng" class="control-label">CURRENT PLACE (lng) </label>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.00000001" name="current_lng" id="current_lng" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- DISTANCE -->
                            <div class="row">
                                <div class="col-form-label col-sm-6 text-center ">
                                    <label for="distance" class="control-label">DISTANCE (km)</label>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.001" name="distance" id="distance" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- STAY AT HOME -->
                            <input type="hidden" name="stay_at_home" id="stay_at_home" class="form-control">
                            <!-- id値を送信 -->
                            <input type="hidden" name="user_id" id="user_id" value="{{$profile->user_id}}" />

                            <!-- 家・現在地の画像とプログレスバー -->
                            <div class="container">
                                <div class="parent" style="position: relative;" width="340px">
                                    <img src="{{ asset('img/icon/home_pin.png', $is_production) }}" id="athome_img" style="padding:1px; width:50px; display: none;" >
                                    <img src="{{ asset('img/icon/goingout_pin.png', $is_production) }}" id="goingout_img" style="padding:1px; width:50px; display: none;">
                                </div>
                            </div>
                            <div class="container mb-5">
                                <div class="row" style="margin:0 15px">
                                    <div class="bar" style="width: 0px; height: 20px; background-color:#28a745;"></div>
                                </div>
                            </div>

                            <!-- ログ送信ボタン -->
                            <div class="form-group">
                                <div class="col">
                                    <div id="athome_sec" class="section">
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="send_log" id="stayhome_btn">Yes, I'm at home (*´ω｀*)</button>
                                    </div>
                                    <div id="goingout_sec" class="section">
                                        <button type="submit" class="btn btn-danger btn-lg btn-block" name="send_log" id="goingout_btn">No..., I'm going out(´;︵;`)</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

                
                
        </div>
    </div>
</div>
@endsection

@section('javascript-footer')
{{-- この場所に画面毎(フッタ位置)のjsを記述する --}}
{{-- <script src="{{ asset('js/watch_position.js') }}" defer></script> --}}

<script type="text/javascript">    

    window.onload = function(){
        //1000ミリ秒（1秒）毎に関数を呼び出す
        setInterval("getGeolocation()", 1000*60);
    }
    
    //現在時刻を表示する関数
    function getGeolocation(){

        // ユーザーの現在の位置情報を取得
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

        // ユーザーの現在の位置情報を取得
        function successCallback(position) {
            var current_lat = position.coords.latitude;
            var current_lng = position.coords.longitude;
            var current_lat_round = Math.round(current_lat * 100000000) / 100000000;
            var current_lng_round = Math.round(current_lng * 100000000) / 100000000;
            // htmlに出力
            $("#current_lat").html(current_lat_round);
            $("#current_lng").html(current_lng_round);
        
            // 日付データの取得
            var now = new Date();
            var y = now.getFullYear();
            var m = now.getMonth() + 1;
            var d = now.getDate();
            var hh = now.getHours();
            var mm = now.getMinutes();
            var ss = now.getSeconds();
            var date_time = y + '-' + m + '-' + d + '-' + hh + '-' + mm + '-' + ss;
            var key = y + '-' + m + '-' + d + '-' + hh + '-' + mm;
            // var date = y + '-' + m + '-' + d + '-' + hh + '-' + 

            // オブジェクトにし、LocalStorageへ保存
            var log = {
                dt : date_time,
                lat : current_lat_round,
                lng : current_lng_round,
            };
            var log = JSON.stringify(log);
            localStorage.setItem(key, log);

        } // function successCallback(position) 終了タグ

        
        /***** 位置情報が取得できない場合 *****/
        function errorCallback(error) {
            var err_msg = "";
            switch (error.code) {
                case 1:
                    err_msg = "位置情報の利用が許可されていません";
                    break;
                case 2:
                    err_msg = "デバイスの位置が判定できません";
                    break;
                case 3:
                    err_msg = "タイムアウトしました";
                    break;
            }
            document.getElementById("show_result").innerHTML = err_msg;
        }

    }



    // セクション全体を非表示にする
    $('.btn_section').hide();
    $('.section').hide();

    // 自宅の緯度経度をhtml経由でDBから取得
    var origin_lat = $('#origin_lat').val();
    var origin_lng = $('#origin_lng').val();

    $(function(){
        if(origin_lat.length !== 0 || origin_lng.length !== 0){
            // 緯度経度のデータが登録済みの場合、ログ取得ボタンを表示
            $('#getlog_section').fadeIn();
        }else{
            // 緯度経度のデータが未登録の場合は、プロフィール編集ページへ誘導
            $('#prof_section').fadeIn();
        }
    });

    // ログ取得ボタンクリックで発火
    $('#get_log').on('click', function(){

        $('#athome_img').fadeIn();
        // ユーザーの現在の位置情報を取得
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

        // ユーザーの現在の位置情報を取得
        function successCallback(position) {
            var current_lat = position.coords.latitude;
            var current_lng = position.coords.longitude;
            var current_lat_round = Math.round(current_lat * 100000000) / 100000000;
            var current_lng_round = Math.round(current_lng * 100000000) / 100000000;
            // htmlに出力
            $("#current_lat").val(current_lat_round);
            $("#current_lng").val(current_lng_round);

            // 緯度経度から、自宅と現在地の距離を算出
            var distance_km = distance(origin_lat, origin_lng, current_lat, current_lng)
            function distance(lat1, lng1, lat2, lng2) {
                lat1 *= Math.PI / 180;
                lng1 *= Math.PI / 180;
                lat2 *= Math.PI / 180;
                lng2 *= Math.PI / 180;
                return 6371 * Math.acos(Math.cos(lat1) * Math.cos(lat2) * Math.cos(lng2 - lng1) + Math.sin(lat1) * Math.sin(lat2));
            }
            // 小数点３位以下を四捨五入グローバル変数に代入    
            distance_round = Math.round(distance_km * 1000) / 1000;
            console.log(distance_round);
        
            function htmloutput(){
                if(distance_round<=0.03){
                    //距離が30m以内     
                    $.when(
                        $('.bar').animate({width: '10%'}, 3000)
                    ).done(function() {
                        $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'5%'});
                        $('#goingout_img').fadeIn('slow');
                        // htmlに出力
                        $("#distance").val(distance_round);
                        $("#stay_at_home").val('1');
                        $('#athome_sec').fadeIn();
                    }).fail(function() {
                        console.log('error');
                    });
                    $('#athome_sec').fadeIn();
                }else if(distance_round<=0.3){
                    $.when(
                        $('.bar').animate({width: '50%'}, 3000)
                    ).done(function() {
                        $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'20%'});
                        $('#goingout_img').fadeIn('slow');
                        // htmlに出力
                        $("#distance").val(distance_round);
                        $("#stay_at_home").val('0');
                        $('#goingout_sec').fadeIn();
                    }).fail(function() {
                        console.log('error');
                    });
                }else if(distance_round<=10){
                    $.when(
                        $('.bar').animate({width: '70%'}, 5000)
                    ).done(function() {
                        $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'50%'});
                        $('#goingout_img').fadeIn('slow');
                        // htmlに出力
                        $("#distance").val(distance_round);
                        $("#stay_at_home").val('0');
                        $('#goingout_sec').fadeIn();
                    }).fail(function() {
                        console.log('error');
                    });
                } else {
                    $.when(
                        $('.bar').animate({width: '100%'}, 7000)
                    ).done(function() {
                        $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'85%'});
                        $('#goingout_img').fadeIn('slow');
                        // htmlに出力
                        $("#distance").val(distance_round);
                        $("#stay_at_home").val('0');
                        $('#goingout_sec').fadeIn();
                    }).fail(function() {
                        console.log('error');
                    });
                };
            };
            // 実行
            htmloutput();

            // function anim_01 (){
            //     $('#athome_img').fadeIn();
            // }
            // function anim_02 (){
            //     $('.bar').animate({width: '10%'}, 3000)
            // }
            // function anim_03 (){
            //     $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'5%'});
            //     $('#goingout_img').fadeIn('slow');
            // }
            // function anim_04 (){
            //     $("#distance").val(distance_round);
            //     $("#stay_at_home").val('NO');
            //     $('#goingout_sec').fadeIn();
            // }


            // HOMEからの距離により選択できるボタンの表示を変更
            if(distance_round<=0.03){
                //距離が30m以内
                $('#athome_sec').fadeIn();
                $("#quarantine").val('YES');
            }else{
                
            }
            





        } // function successCallback(position) 終了タグ
        

        /***** 位置情報が取得できない場合 *****/
        function errorCallback(error) {
            var err_msg = "";
            switch (error.code) {
                case 1:
                    err_msg = "位置情報の利用が許可されていません";
                    break;
                case 2:
                    err_msg = "デバイスの位置が判定できません";
                    break;
                case 3:
                    err_msg = "タイムアウトしました";
                    break;
            }
            document.getElementById("show_result").innerHTML = err_msg;
        }



    });
  
    



   
    

</script>

@endsection
