<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        dd($id);
        // 既存のモデルを更新
        $user = new User;
        $user->id = Auth::user()->id;
        $user->name = $request->user_name;
        $user->email = $request->email;
        $user->save();

        // 既存のモデルを更新するか、存在しない場合は新しいモデルを作成 
        $profile = Profile::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'original_lat' => $request->lat,
                'original_lng' => $request->lng,
                'cohabitant' => $request->cohabitant,
                'contact_weekday' => $request->contact_weekday,
                'contact_weekend' => $request->contact_weekend,
            ]
        );
        return redirect('/');
    }

    //登録処理関数
    public function store(Request $request)
    {

        $profile = new User;
        $profile->user_id = Auth::user()->id;
        $profile->save();

        // 最新のDB情報を取得して返す
        $tasks = Profile::where('user_id', Auth::user()->id)
            ->orderBy('deadline', 'asc')
            ->get();
        return $tasks;
    }

    //表示処理関数
    public function index()
    {
        $profile = Profile::where('user_id', Auth::user()->id)
            ->leftJoin('users', 'users.id', '=', 'user_id')
            ->get();

        return $profile;
    }

    //削除処理関数
    public function destroy($task_id)
    {
        $task = Profile::where('user_id', Auth::user()->id)->find($task_id);
        $task->delete();

        // 最新のDB情報を取得して返す
        $tasks = Profile::where('user_id', Auth::user()->id)
            ->orderBy('deadline', 'asc')
            ->get();
        return $tasks;
    }
}
