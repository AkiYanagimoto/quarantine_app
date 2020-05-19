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

            <div class="title_block">
                <h3 class="text-center">YOUR PROFILE</h3>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-md-10" style="padding-top: 20px">
                    <form action="{{ url('profile/'.Auth::id(), $is_production) }}" method="post">

                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <!-- USER NAME -->
                            <div class="col mb-3">
                                <label for="user_name" class="control-label">NAME</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" value="{{ old('user_name') ?: $profile->name}}">
                            </div>
                            <!-- USER NAME -->
                            <div class="col mb-3">
                                <label for="email" class="control-label">E-MAIL</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') ?: $profile->email}}">
                            </div>
                            <!-- COUNTRY -->
                            {{-- <div class="col">
                                <label for="country" class="control-label">COUNTRY</label>
                                <input type="text" maxlength="3" value="392" name="country" id="country" class="form-control" value="{{ old('country') ?: $profile->country_id}}">
                            </div> --}}
                            <!-- POSTAL CODE -->
                            {{-- <div class="col">
                                <label for="postal_code" class="control-label">POSTAL CODE</label>
                                <input type="text" maxlength="7" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') ?: $profile->postal_code}}">
                            </div> --}}
                            <!-- LATITUDE -->
                            <div class="col mb-3">
                                <label for="lat" class="control-label">LATITUDE(HOME)</label>
                                <input type="text" name="lat" id="lat" class="form-control" value="{{ old('lat') ?: $profile->origin_lat}}">
                            </div>
                            <!-- LONGITUDE -->
                            <div class="col mb-3">
                                <label for="lng" class="control-label">LONGITUDE(HOME)</label>
                                <input type="text" name="lng" id="lng" class="form-control" value="{{ old('lng') ?: $profile->origin_lng}}">
                                <p class="text-muted">
                                    ＊Lat of current location...<span id="current_lat"></span><br>
                                    ＊Lng of current location...<span id="current_lng"></span>
                                <p>
                                <div class="text-right">
                                <span id="result"></span>
                                <button type="button" id="input_latlng" class="btn btn-secondary btn-sm">Get current position</button>
                                </div>
                            </div>
                            <!-- COHABITANT -->
                            <div class="col mb-3">
                                <label for="cohabitant" class="control-label">COHABITANT</label>
                                <input type="number" name="cohabitant" id="cohabitant" class="form-control" value="{{ old('cohabitant') ?: $profile->cohabitant}}">
                            </div>
                            <!-- CONTACT WEEKDAY -->
                            <div class="col mb-3">
                                <label for="contact_weekday" class="control-label">HIGH-RISK CONTACT (DAILY AVERAGE)</label>
                                <input type="number" name="contact_weekday" id="contact_weekday" class="form-control" value="{{ old('contact_weekday') ?: $profile->contact_weekday}}">
                            </div>
                            {{-- <!-- CONTACT WEEKEND -->
                            <div class="col">
                                <label for="contact_weekend" class="col-sm-3 control-label">CONTACT WEEKEND</label>
                                <input type="number" name="contact_weekend" id="contact_weekend" class="form-control" value="{{ old('contact_weekend') ?: $profile->contact_weekend}}">
                            </div> --}}
                        </div>
                        <!--送信ボタン-->
                        <div class="col-sm-offset-3 col">
                            <button type="submit" name="save_prof" id="save_prof" class="btn btn-success btn-lg btn-block">{{ __('SAVE') }}</button>
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
{{-- <script src="{{ asset('js/geolocation.js') }}" defer></script> --}}
<script type="text/javascript">

    //ユーザーの現在の位置情報を取得
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    /***** ユーザーの現在の位置情報を取得 *****/
    function successCallback(position) {
        gl_lat = position.coords.latitude;
        gl_lng = position.coords.longitude;

        // htmlへ出力
        document.getElementById("current_lat").innerHTML = Math.round(gl_lat * 100000000) / 100000000;
        document.getElementById("current_lng").innerHTML  = Math.round(gl_lng * 100000000) / 100000000;
    }

    document.getElementById("input_latlng").onclick = function(){
        // htmlへ出力
        document.getElementById("lat").value = Math.round(gl_lat * 100000000) / 100000000;
        document.getElementById("lng").value = Math.round(gl_lng * 100000000) / 100000000;
        document.getElementById("result").innerHTML = 'Done!!';
    };

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
    
</script>
@endsection