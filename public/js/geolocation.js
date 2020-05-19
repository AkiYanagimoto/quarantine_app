//ユーザーの現在の位置情報を取得
navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

/***** ユーザーの現在の位置情報を取得 *****/
function successCallback(position) {
    var gl_lat = position.coords.latitude;
    var gl_lng = position.coords.longitude;
    var accuracy = position.coords.accuracy;
    // htmlへ出力
    document.getElementById("current_lat").innerHTML = Math.round(gl_lat * 1000000) / 1000000;
    document.getElementById("current_lng").innerHTML = Math.round(gl_lng * 1000000) / 1000000;

}

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
