<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Log;
use App\Isolation;
use Auth;
use Carbon\Carbon;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ユーザーのプロフィール取得
        $profile = User::where('users.id', Auth::id())
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.id', 'users.name', 'users.email', 'profiles.country_id', 'profiles.postal_code', 'profiles.origin_lat', 'profiles.origin_lng', 'profiles.cohabitant', 'profiles.contact_weekday', 'profiles.contact_weekend')
            ->first();

        // 直近のログを取得
        $last_log = Log::where('user_id', Auth::id())
            ->latest('date_time')
            ->first();

        // 最終更新日
        $day = $last_log->date_time->format('Y-m-d');

        // ユーザーのログが有る場合
        if ($last_log !== null) {
            // 最終更新日のログ一覧の取得
            $logs = Log::where('user_id', Auth::id())
                ->whereDate('date_time', $day)
                ->oldest('date_time')
                ->get();
            // 最終更新日のログ一覧の取得:自宅隔離成功
            $stayhome_logs = Log::where('user_id', Auth::id())
                ->whereDate('date_time', $day)
                ->where('stay_at_home', '=', '1')
                ->oldest('date_time')
                ->get();
            // 最終更新日のログ一覧の取得:自宅隔離失敗
            $goingout_logs = Log::where('user_id', Auth::id())
                ->whereDate('date_time', $day)
                ->where('stay_at_home', '=', '0')
                ->oldest('date_time')
                ->get();

            // ユーザーのログが全くない場合
        } else {
            return redirect('/location');
        }



        // // 今日のログを取得
        // $day7 = date("Y-m-d");
        // $logs_day7 = Log::where('user_id', Auth::id())
        //     ->whereDate('date_time', $day7)
        //     ->oldest('date_time')
        //     ->get();
        // // 今日の外出回数
        // $goingout_today = Log::where('user_id', Auth::id())
        //     ->whereDate('date_time', $day7)
        //     ->where('stay_at_home', '=', '0')
        //     ->get();

        // if (count($logs_day7) == 0) {
        //     // 今日の日付のログがない場合、最終更新日のログを取得する

        //     // 直近のログの日付
        //     $last_log = Log::where('user_id', Auth::id())
        //         ->latest('date_time')
        //         ->firstOr(function () {
        //             // 全くログがない場合
        //             $day_records = null;
        //             $goingout = null;
        //             exit;
        //         });
        //     $last_day = $last_log->date_time->format('Y-m-d');
        //     // 最終更新日のログ一覧の取得
        //     $logs_day_log = Log::where('user_id', Auth::id())
        //         ->whereDate('date_time', $last_day)
        //         ->oldest('date_time')
        //         ->get();
        //     // 外出回数
        //     $goingout_lastday = Log::where('user_id', Auth::id())
        //         ->whereDate('date_time', $last_day)
        //         ->where('stay_at_home', '=', '1')
        //         ->get();
        //     $day_records = $logs_day_log;
        //     $goingout = $goingout_lastday;
        // } else {
        //     // 今日のログがある場合
        //     $day_records = $logs_day7;
        //     $goingout = $goingout_today;
        // }

        // １週間前の日付取得
        $day1 = date("Y-m-d", strtotime("-6 day"));

        // １週間の隔離状況
        $isolation_week = Isolation::where('user_id', Auth::id())
            ->where('date', '>=', $day1)
            ->oldest('date')
            ->get();

        // １週間の隔離成功日数
        $isolation_week_success = Isolation::where('user_id', Auth::id())
            ->where('date', '>=', $day1)
            ->where('stay_at_home', '=', '1')
            ->get();
        // １週間の隔離失敗日数
        $isolation_week_failed = Isolation::where('user_id', Auth::id())
            ->where('date', '>=', $day1)
            ->where('stay_at_home', '=', '0')
            ->get();

        $count_iso7days_success = $isolation_week_success->count();

        // 30日前の日付取得
        $day_last30days = date("Y-m-d", strtotime("-31 day"));

        // ３０日間の隔離成功日数
        $isolation_30days_success = Isolation::where('user_id', Auth::id())
            ->where('date', '>=', $day_last30days)
            ->where('stay_at_home', '=', '1')
            ->oldest('date')
            ->get();
        $count_iso30days_success = $isolation_30days_success->count();

        // ３０日間の隔離失敗日数
        $isolation_30days_failed = Isolation::where('user_id', Auth::id())
            ->where('date', '>=', $day_last30days)
            ->where('stay_at_home', '=', '0')
            ->oldest('date')
            ->get();
        $count_iso30days_failed = $isolation_30days_failed->count();

        // アカウント登録以降の隔離成功日数
        $isolation_success = Isolation::where('user_id', Auth::id())
            ->where('stay_at_home', '=', '1')
            ->get();
        $count_success = $isolation_success->count();
        // アカウント登録以降の貢献人数
        $contribution = $count_success * $profile->contact_weekday;

        return view('profile.profile', [
            'profile' => $profile, // ユーザープロフィール
            'logs' => $logs,
            'stayhome_logs' => $stayhome_logs,
            'goingout_logs' => $goingout_logs,
            'day' => $day,

            // 'day_records' => $day_records, // 今日もしくは最終更新日のログ一覧
            // 'goingout' => $goingout, // 今日もしくは最終更新日の外出回数
            // 'logs_day_log' => $logs_day_log,
            // 'goingout_lastday' => $goingout_lastday,
            // // 'count_goingout_lastday' => $count_goingout_lastday,
            'isolation_week' => $isolation_week,
            'isolation_week_success' => $isolation_week_success,
            'isolation_week_failed' => $isolation_week_failed,
            // 'count_iso7days_success' => $count_iso7days_success,
            // 'count_iso30days_success' => $count_iso30days_success,
            // 'count_iso30days_failed' => $count_iso30days_failed,
            'count_success' => $count_success,
            'contribution' => $contribution,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        dd($request);
        // // ユーザーのログの有無を確認
        // $log = Log::where('user_id', Auth::id())->firstOr(function () {
        //     // ...
        // });


        // // 今日のログを取得
        // $day7 = date("Y-m-d");
        // $logs_day7 = Log::where('user_id', Auth::id())
        //     ->whereDate('date_time', $day7)
        //     ->oldest('date_time')
        //     ->get();
        // // 今日のログの有無
        // if (count($logs_day7) == 0) {
        //     // 直近のログを取得
        //     $last_log = Log::where('user_id', Auth::id())
        //         ->latest('date_time')
        //         ->first();
        //     $day = $last_log->date_time->format('Y-m-d');
        // } else {
        //     $day = $day7;
        // }

        // 既存のモデルを更新するか、存在しない場合は新しいモデルを作成 
        // $user_record = Isolation::where('user_id', Auth::id())
        //     ->where('date', $day)
        //     ->exists();
        // if ($user_record == false) {
        //     // 既存のモデルなし、新しいモデルを作成 
        //     $iso = new Isolation;
        //     $iso->user_id = Auth::id();
        //     $iso->date = $day;
        //     $iso->stay_at_home = $request->isolation;
        //     $iso->save();
        // } else {
        //     // 既存のモデルあり、更新 
        //     Isolation::where('user_id', Auth::id())
        //         ->where('date', $day)
        //         ->update(['stay_at_home' => 1]);
        // }
        //「/」ルートにリダイレクト
        return redirect('/profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = User::where('users.id', $id)
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.id', 'users.name', 'users.email', 'profiles.country_id', 'profiles.postal_code', 'profiles.origin_lat', 'profiles.origin_lng', 'profiles.cohabitant', 'profiles.contact_weekday', 'profiles.contact_weekend')
            ->first();

        return view('profile.edit', [
            'profile' => $profile
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'email' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'cohabitant' => 'required',
            'contact_weekday' => 'required',
        ]);
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('profile/' . $id . '/edit')
                ->withInput()
                ->withErrors($validator);
        }

        // dd($request);
        // users tableを更新
        $user = User::find($id);
        $user->name = $request->user_name;
        $user->email = $request->email;
        $user->save();

        // profile tableを更新
        $profile = Profile::find($id);
        $profile->origin_lat = $request->lat;
        $profile->origin_lng = $request->lng;
        $profile->cohabitant = $request->cohabitant;
        $profile->contact_weekday = $request->contact_weekday;
        $profile->save();

        // 既存のモデルを更新するか、存在しない場合は新しいモデルを作成 
        // $profile = Profile::firstOrCreate(
        //     ['user_id' => $id],
        //     [
        //         'origin_lat' => $request->lat,
        //         'origin_lng' => $request->lng,
        //         'cohabitant' => $request->cohabitant,
        //         'contact_weekday' => $request->contact_weekday,
        //     ]
        // );

        return redirect('/location');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //api画面表示用関数
    public function api_ajax()
    {
        return view('profile.api_ajax');
    }
}
