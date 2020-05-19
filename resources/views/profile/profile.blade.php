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
            <!-- バリデーションエラーの表⽰に使⽤するエラーファイル-->
            @include('common.errors')
                                
            <div class="panel panel-default">
                <div class="panel-heading m-5">
                    <h3 class="text-center">DAYLY LOG </h3>
                    <h4 class="text-center">({{$day}})</h4>
                </div>
                <div class="panel-body">
                    @if($logs !== null)
                        <div class="row justify-content-center">
                            <table class="table table-hover" style="margin:10px">
                                <tbody>
                                    <div class="col-sm-offset-3 col-sm-6">
                                        @foreach($logs as $log)
                                            <tr class="table-light" style="background-color: transparent; border-color:transparent;">
                                                <th scope="row" style="background-color: transparent; border-color:transparent; width:20%; padding:0;">
                                                    <!-- 時間と距離 -->
                                                    <p class="m-0 text-center">{{$log->date_time->format("H:m")}} </p>
                                                    @if($log->distance >= 1)
                                                        <p class="m-0 text-center">{{ round($log->distance) }}km</p>
                                                    @else
                                                        <p class="m-0 text-center">{{$log->distance*1000}}m</p>
                                                    @endif
                                                </th>
                                                <td style="background-color: transparent; border-color:transparent; width:65%; padding:0;">
                                                    @if($log->distance <= 0.03)
                                                        <!-- 家と現在地のアイコン -->
                                                        <div class="parent" style="position: relative;" width="200px">
                                                            <img src="{{ asset('img/icon/home_pin.png', $is_production) }}" id="athome_img" style="padding:1px; width:40px;" >
                                                            <img src="{{ asset('img/icon/goingout_pin.png', $is_production) }}" id="goingout_img" style="padding:1px; width:40px; position:absolute; top:0; left:8%;">
                                                        </div>
                                                        <!-- プログレスバー -->
                                                        <div class="row" style="margin:0 20px">
                                                            <div class="bar" style="width: 10%; height: 10px; background-color:#28a745;"></div>
                                                        </div>
                                                    @elseif($log->distance <= 0.3)
                                                        <div class="parent" style="position: relative;" width="200px">
                                                            <img src="{{ asset('img/icon/home_pin.png', $is_production) }}" id="athome_img" style="padding:1px; width:40px;" >
                                                            <img src="{{ asset('img/icon/goingout_pin.png', $is_production) }}" id="goingout_img" style="padding:1px; width:40px; position:absolute; top:0; left:20%;">
                                                        </div>
                                                        <div class="row" style="margin:0 20px">
                                                            <div class="bar" style="width: 50%; height: 10px; background-color:#28a745;"></div>
                                                        </div>                                           
                                                    @elseif($log->distance <= 10)
                                                        <div class="parent" style="position: relative;" width="200px">
                                                            <img src="{{ asset('img/icon/home_pin.png', $is_production) }}" id="athome_img" style="padding:1px; width:40px;" >
                                                            <img src="{{ asset('img/icon/goingout_pin.png', $is_production) }}" id="goingout_img" style="padding:1px; width:40px; position:absolute; top:0; left:50%;">
                                                        </div>
                                                        <div class="row" style="margin:0 20px">
                                                            <div class="bar" style="width: 70%; height: 10px; background-color:#28a745;"></div>
                                                        </div>
                                                    @else
                                                        <div class="parent" style="position: relative;" width="200px">
                                                            <img src="{{ asset('img/icon/home_pin.png', $is_production) }}" id="athome_img" style="padding:1px; width:40px;" >
                                                            <img src="{{ asset('img/icon/goingout_pin.png', $is_production) }}" id="goingout_img" style="padding:1px; width:40px; position:absolute; top:0; left:100%;">
                                                        </div>
                                                        <div class="row" style="margin:0 20px">
                                                            <div class="bar" style="width: 100%; height: 10px; background-color:#28a745;"></div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="background-color: transparent; border-color:transparent; width:15%; padding:0;">
                                                    <!-- 外出自粛成功 -->
                                                    @if($log->stay_at_home === 1)
                                                        <span class="badge badge-pill badge-success m-2">Success</span>
                                                    @else
                                                        <span class="badge badge-pill badge-secondary mt-2">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class ="row justify-content-center">
                            <p>ログがありません</p>
                            <div class="col-sm-offset-3 col-sm-6">
                                <a href="{{ url('/location', $is_production) }}" class="btn btn-outline-success btn-lg btn-block">
                                    {{ __('CONTRIBUTE MORE!!') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- 1日の総括 -->
                    <div class="container mt-5">
                        <div class=" justify-content-center">
                            <h3 class="text-center">DAYLY REPORT</h3>
                        </div>
                        <div class="justify-content-center">
                            <form action="{{ url('profile' , $is_production) }}" method="POST" class="form-horizontal">
                                {{ csrf_field() }}
                                <!-- 1日の総括 -->
                                <div class="form-group">    
                                    <div class="col mb-5">

                                        




                                        {{-- @if($today_record == 0)
                                            <p>You left home {{count($goingout_logs)}}times in last recorded date. Did you really stay home all day?? </p>

                                            @if(count($goingout_lastday) == 0)
                                                <label><input type="radio" name="isolation" value="1">SELF-ISOLATION SUCCESS!!</label>
                                                <p>Yes, I stayed at home all day!</p>
                                                <label><input type="radio" name="isolation" value="0">SELF-ISOLATION FAILED!!</label>
                                                <p>No, I went out... had no chois.</p>
                                            @else
                                                <label><input type="radio" name="isolation" value="1">SELF-ISOLATION SUCCESS!!</label>
                                                <p>I left home but I didn't have high-risk contact with anyone.</p>
                                                <label><input type="radio" name="isolation" value="0">SELF-ISOLATION FAILED!!</label>
                                                <p>There is no record but left home yesterday</p>
                                            @endif
                                        @else
                                            <p>You left home {{count($goingout_today)}}times today. Did you really stay home all day?? </p>
                                            @if(count($goingout_lastday) == 0)
                                                <label><input type="radio" name="isolation" value="1">SELF-ISOLATION SUCCESS!!</label>
                                                <p>Yes, I stayed at home all day!</p>
                                                <label><input type="radio" name="isolation" value="0">SELF-ISOLATION FAILED!!</label>
                                                <p>No, I went out... had no chois.</p>
                                            @else
                                                <label><input type="radio" name="isolation" value="1">SELF-ISOLATION SUCCESS!!</label>
                                                <p>I left home but I didn't have high-risk contact with anyone.</p>
                                                <label><input type="radio" name="isolation" value="0">SELF-ISOLATION FAILED!!</label>
                                                <p>There is no record but left home yesterday</p>
                                            @endif
                                        @endif --}}
                                        <!-- 送信 -->
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="stayhome" id="day_report" value="1">SEND SCORE</button>
                                        <button type="submit" class="btn btn-danger btn-lg btn-block" name="goingout" id="day_report" value="1">GOING OUT(´;︵;`)</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
            
                </div>

                
                        {{-- {{count($stayhome_logs)}}
                        {{count($goingout_logs)}} --}}

                        {{-- <table class="table table-borderless todays-record-table">
                            <tbody>
                                @if(count($logs_day7) == 0)
                                    <!-- 今日のログがない場合、最近の日付のログを表示 -->
                                    @foreach ($logs_day_log as $item)
                                    <tr>
                                        <td class="table-text">
                                            {{$item->date_time}}
                                            
                                        </td>
                                        <td class="table-text">
                                            @if($item->stay_at_home === '1')
                                                <img src="{{ asset('img/icon/heart.png') }}" class="float-right" width="30px" >
                                            @else
                                                <img src="{{ asset('img/icon/heart.png') }}" class="float-right" width="30px" >
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <!-- 今日のログが入っている場合、今日のログを表示 -->
                                    @foreach ($logs_day7 as $item)
                                        <tr>
                                            <td class="table-text">
                                                <div>{{ $item->date_time }}</div>
                                            </td>
                                            <td class="table-text">
                                                @if ($item->stay_at_home == 1)
                                                <div>
                                                    <img src="{{ asset('img/icon/heart.png') }}" class="float-right" width="30px" >
                                                </div>
                                                @elseif ($item->stay_at_home == 0)
                                                <div>
                                                    <img src="{{ asset('img/icon/heart.png') }}" class="float-right" width="30px" >
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table> --}}
            

               

                <h3 class="text-center mb-5">YOUR CONTRIBUTION</h3>

                <div class>
                
                <h3 class="text-center ">{{$contribution}} PEOPLE</h3>
                <h5 class="text-center mb-5">APPRECIATE YOUR SINCER CONTRIBUTION !! </h5>

                {{-- <h6 class="text-center">SELF-ISOLATION: {{$count_iso7days_success}} DAYS/LAST 7DAYS</h6>
                <h6 class="text-center">SELF-ISOLATION: {{$count_iso30days_success}} DAYS/LAST 30DAYS</h6>
                <h6 class="text-center">GOING OUT: {{$count_iso30days_failed}} DAYS/LAST 30DAYS</h6>
                <h6 class="text-center">SELF-ISOLATION: {{$count_success}} DAYS (TOTAL)</h6> --}}

                </div>

                <!-- プロフィール更新ボタン -->
                <div class="col-sm-offset-3 col-sm-6">
                    <a href="{{ url('profile/'.$profile->id.'/edit', $is_production) }}" class="btn btn-success btn-lg btn-block">
                        {{ __('EDIT YOUR PROFILE') }}
                    </a>
                </div>

                </div>
            </div>
                
        </div>
    </div>
</div>
@endsection

@section('javascript-footer')
{{-- この場所に画面毎(フッタ位置)のjsを記述する --}}

<script type="text/javascript">

        const val = JSON.parse(localStorage.getItem('2020-4-22-21-59'));
        console.log(val);

// const logs = @json($logs);
//     console.log(logs);
//     $(function() {
//     for( var i=0; i<logs.length; i++) {
//             $('#output').html(logs[i]);
//         }
//     });
    
    

// データから一覧テーブルを出力する関数
// function (){
//     // ログ一覧を取得
    
//     // 件数だけ繰り返し処理
//     


//     // テーブルを作成
//         function make_html(data){
//             var str '';
//             for( var i=0; i<logs.length; i++) {
                
                
//                 str += `<tr class="table-light" style="background-color: transparent; border-color:transparent;">
//                         <th scope="row" style="background-color: transparent; border-color:transparent; width:20%; padding:0;">
//                             <p class="m-0 text-center"> ${log->date_time->format("H:m")} </p>
//                             <p class="m-0 text-center"> ${log->distance} km</p>
//                         </th>
//                         <!-- 家・現在地の画像とプログレスバー -->
//                         <td style="background-color: transparent; border-color:transparent; width:80%; padding:0;">
//                             {{-- 家と現在地のアイコン --}}
//                             <div class="parent" style="position: relative;" width="200px">
//                                 <img src="{{ asset('img/icon/home_pin.png') }}" id="athome_img" style="padding:1px; width:40px; display: none;" >
//                                 <img src="{{ asset('img/icon/goingout_pin.png') }}" id="goingout_img" style="padding:1px; width:40px; display: none;">
//                             </div>
//                             {{-- プログレスバー --}}
//                             <div class="row" style="margin:0 20px">
//                                 <div class="bar" style="width: 0px; height: 10px; background-color:#28a745;"></div>
//                             </div>
//                         </td>
//                     <tr>`;
//             };
//         };

//         // 実行
//         $('#echo').html(make_html(data));
        

//     for( var i=0; i<logs.length; i++) {
        
        
//         function progressbar(){
//             $('#athome_img').fadeIn('slow');
//             if(logs[i].distance<=0.03){
//                 //距離が30m以内     
//                 $.when(
//                     $('.bar').animate({width: '10%'}, 1000)
//                 ).done(function() {
//                     $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'10%'});
//                     $('#goingout_img').fadeIn('slow');
//                 }).fail(function() {
//                     console.log('error');
//                 });
//             }else if(logs[i].distance<=0.3){
//                 $.when(
//                     $('.bar').animate({width: '50%'}, 3000)
//                 ).done(function() {
//                     $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'20%'});
//                     $('#goingout_img').fadeIn('slow');;
//                 }).fail(function() {
//                     console.log('error');
//                 });
//             }else if(logs[i].distance<=10){
//                 $.when(
//                     $('.bar').animate({width: '70%'}, 5000)
//                 ).done(function() {
//                     $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'50%'});
//                     $('#goingout_img').fadeIn('slow');
//                 }).fail(function() {
//                     console.log('error');
//                 });
//             } else {
//                 $.when(
//                     $('.bar').animate({width: '100%'}, 7000)
//                 ).done(function() {
//                     $('#goingout_img').css({'position':'absolute', 'top':'0', 'left':'85%'});
//                     $('#goingout_img').fadeIn('slow');
//                 }).fail(function() {
//                     console.log('error');
//                 });
//             };
//         };
//         // 実行
//         progressbar();
//     };
// };
        



// $(function () {

//     $('button[name="stayhome"]').hide();
//     $('button[name="goingout"]').hide();

//     // ラジオボタンを選択変更したら実行
//     $('input[name="isolation"]').change(function () {

//         // value値取得
//         var isolation = $(this).val();
//         // コンソールログで確認
//         console.log(isolation);

//         if(isolation == 1){
//             $('button[name="stayhome"]').show();
//             $('button[name="goingout"]').hide();

//         }else{
//             $('button[name="stayhome"]').hide();
//             $('button[name="goingout"]').show();
//         }
//     });
// });

</script>

@endsection