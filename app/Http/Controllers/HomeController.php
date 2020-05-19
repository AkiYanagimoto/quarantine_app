<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Profile;
use App\Log;
use App\Isolation;
use Validator;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 新規登録者（プロフィールが未登録）の場合、モデルを作成
        $profile = Profile::firstOrCreate(['user_id' => Auth::id()]);

        return view('location', ['profile' => $profile]);

        // if (!isset($profile[0])) {
        //     // プロフィールがない場合（新規登録）は、プロフィールを新規作成し、編集ページへ
        //     $profile = Profile::create(['user_id' => Auth::id()]);
        //     return view('profile/' . $profile->id . '/edit', ['profile' => $profile]);
        // } else {
        //     // 既にプロフィールがある場合

        // }
    }

    // ログを記録
    public function store(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'distance' => 'required',
            'stay_at_home' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/location')
                ->withInput()
                ->withErrors($validator);
        }


        // Userのmodelクラスのインスタンスを生成
        $log = new Log;
        $log->user_id = $request->user_id;
        $log->distance = $request->distance;
        $log->date_time = date("Y-m-d H:i:s");
        $log->stay_at_home = $request->stay_at_home;
        $log->save();

        //「/」ルートにリダイレクト
        return redirect('/profile');
    }
}
