@extends('layouts.app')

@section('css')
{{-- この場所に画面毎のcssを記述する --}}
@endsection

@section('javascript-head')
{{-- この場所に画面毎(ヘッダ位置)のjsを記述する --}}
<script src="{{ asset('js/api_ajax.js', $is_production) }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">YOUR PROFILE</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- バリデーションエラーの表⽰に使⽤するエラーファイル-->
                    @include('common.errors')

                    <!-- この下に登録済みタスクリストを表⽰ -->
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                            <div id="echo"><div>
                            
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection