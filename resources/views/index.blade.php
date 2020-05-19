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
            <div class="title_block">
                <p class="main_text text-center">STAY HOME</p>
                <p class="main_text text-center">STAY SAFE</p>
            </div>
            <div class="title_block">
                <div class="row justify-content-center">
                    <div class="col">
                        <img src="{{ asset('img/icon/home_san_black.png', $is_production) }}" class="img_size float-right"  >
                    </div>
                    <div class="col">
                        <p class="main_text text-left align-text-bottom ">{{$count_user}}</p>
                    </div>
                </div>
                <p class="main_text text-center">in the World</p>   
            </div>             
            <div class="title_block">
                <div class="row justify-content-center">
                    <!-- ユーザーは認証済み -->
                    @auth
                        <div class="col-sm-offset-3 col-sm-6">
                            <a href="{{ url('/location', $is_production) }}" class="btn btn-outline-success btn-lg btn-block">
                                {{ __('CONTRIBUTE MORE!!') }}
                            </a>
                        </div>
                    @endauth
                    <!-- ユーザーは認証されていない -->
                    @guest
                        <div class="col-sm mb-3">
                            <div class="col-sm-offset-3 ">
                                <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg btn-block">
                                    {{ __('LOGIN') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="col-sm-offset-3">
                                <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg btn-block">
                                    {{ __('REGISTER') }}
                                </a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

       
    </div>
    <div class="row justify-content-center">
        
       
    </div>
</div>
@endsection

@section('javascript-footer')
{{-- この場所に画面毎(フッタ位置)のjsを記述する --}}
@endsection