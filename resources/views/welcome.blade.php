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
            <div class="">

                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- バリデーションエラーの表⽰に使⽤するエラーファイル-->
                    @include('common.errors')
                                       
                    <div class="mb-5">
                        {{-- <h1 class="text-center" style="font-family:Franklin Gothic Medium">STAY HOME</h1>
                        <h1 class="text-center mb-5" style="font-family:Franklin Gothic Medium">STAY SAFE</h1> --}}

                        <img class="logo mx-auto d-block my-5" src="{{ asset('img/stay-home.png' , $is_production) }}" width="200" >

                        <h5 class="text-center">{{$count_user}} FRIENDS</h5>
                        <h5 class="text-center mb-5">ARE COLLABORATIONG!!</h5>

                        <h5 class="text-center">YOUR CONTRIBUTION </h5>
                        <h5 class="text-center mb-5">{{$contribution}} FRIENDS</h5>

                        <h6 class="text-center">SELF-ISOLATION: {{$count_iso7days_success}} DAYS/LAST 7DAYS</h6>
                        <h6 class="text-center">SELF-ISOLATION: {{$count_iso30days_success}} DAYS/LAST 30DAYS</h6>
                        <h6 class="text-center">GOING OUT: {{$count_iso30days_failed}} DAYS/LAST 30DAYS</h6>
                        <h6 class="text-center">SELF-ISOLATION: {{$count_success}} DAYS (TOTAL)</h6>
                    </div>
                    <div>

                            <!-- プロフィール更新ボタン -->
                            <div class="col-sm-offset-3 col-sm-6">
                                <a href="{{ url('home', $is_production) }}" class="btn btn-outline-success btn-lg btn-block">
                                    {{ __('CONTRIBUTE MORE!!') }}
                                </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript-footer')
{{-- この場所に画面毎(フッタ位置)のjsを記述する --}}

@endsection