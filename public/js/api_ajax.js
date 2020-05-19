$(function () {

    // データからhtmlを出力する関数
    function make_dom(data) {

        var str = `<form action="{{ url('profiles/update') }}" method="POST">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label for="user_name" class="col-sm-3 control-label">USER NAME</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" value="${data[0].name}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="col-sm-3 control-label">E-MAIL</label>
                            <input type="text" name="email" id="email" class="form-control" value="${data[0].email}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="country" class="col-sm-3 control-label">COUNTRY</label>
                            <input type="text" maxlength="3" value="392" name="country" id="country" class="form-control" value="${data[0].country_id}" >
                        </div>

                        <div class="col-sm-6">
                            <label for="postal_code" class="col-sm-3 control-label">POSTAL CODE</label>
                            <input type="text" maxlength="7" name="postal_code" id="postal_code" class="form-control" value="${data[0].postal_code}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="lat" class="col-sm-3 control-label">LATITUDE</label>
                            <input type="number" name="lat" id="lat" class="form-control" value="${data[0].origin_lat}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="lng" class="col-sm-3 control-label">LONGITUDE</label>
                            <input type="number" name="lng" id="lng" class="form-control" value="${data[0].origin_lng}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="cohabitant" class="col-sm-3 control-label">COHABITANT</label>
                            <input type="number" name="cohabitant" id="cohabitant" class="form-control" value="${data[0].cohabitant}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="contact_weekday" class="col-sm-3 control-label">CONTACT WEEKDAY</label>
                            <input type="number" name="contact_weekday" id="contact_weekday" class="form-control" value="${data[0].contact_weekday}" >
                        </div>
                        <div class="col-sm-6">
                            <label for="contact_weekend" class="col-sm-3 control-label">CONTACT WEEKEND</label>
                            <input type="number" name="contact_weekend" id="contact_weekend" class="form-control" value="${data[0].contact_weekend}" >
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                    <!-- id値を送信 -->
                    <input type="hidden" name="id" value="${data[0].id}" />

                </form>`

        return str;
    }


    // 登録する関数
    function storeData(id) {
        // console.log(id);
        // 送信先の指定
        const url = '/api/profiles/' + id;
        console.log(url);
        // 入力情報の取得
        var data = {
            id: id,
            user_name: $('#user_name').val(),
            email: $('#email').val(),
            country: $('#country').val(),
            postal_code: $('#postal_code').val(),
            lat: $('#lat').val(),
            lng: $('#lng').val(),
            cohabitant: $('#cohabitant').val(),
            contact_weekday: $('#contact_weekday').val(),
            contact_weekend: $('#contact_weekend').val(),
        };

        // データ送信
        $.ajax({
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                url: url,
                type: 'POST',
                data: JSON.stringify(data),
                processData: false,
                contentType: false
            })
            .done(function (data) {
                // console.log(data);
                console.log('done');
                $('#echo').html(make_dom(data));
            })
            .fail(function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(textStatus);
                console.log('fail');
            })
            .always(function () {
                console.log('post:complete');
            });
    }

    // 表示する関数
    function indexData() {
        const url = '/api';
        $.getJSON(url)
            .done(function (data, textStatus, jqXHR) {
                console.log(data);
                $('#echo').html(make_dom(data));
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status + textStatus + errorThrown);
            })
            .always(function () {
                console.log('get:complete');
            });
    }

    // 削除する関数
    function deleteData(id) {
        //
    }

    // 読み込み時に表示処理
    indexData();

    // 送信ボタンクリック時にstoreData()を処理
    $('#echo').on('click', '.update', function () {
        // 削除するタスクのidを取得
        var id = $(this).attr('id');
        storeData(id);
    });



    // $('#update').on('click', function () {
    //     if (
    //         $('#user_name').val() == '' ||
    //         $('#user_name').val() == '' ||
    //         $('#email').val() == '' ||
    //         $('#country').val() == '' ||
    //         $('#postal_code').val() == '' ||
    //         $('#lat').val() == '' ||
    //         $('#lng').val() == '' ||
    //         $('#cohabitant').val() == '' ||
    //         $('#contact_weekday').val() == '' ||
    //         $('#contact_weekend').val() == ''
    //     ) {
    //         alert('Fill all fields')
    //     } else {

    //         // storeData();
    //         // $('#user_name').val(),
    //         //     $('#email').val(),
    //         //     $('#country').val(),
    //         //     $('#postal_code').val(),
    //         //     $('#lat').val(),
    //         //     $('#lng').val(),
    //         //     $('#cohabitant').val(),
    //         //     $('#contact_weekday').val(),
    //         //     $('#contact_weekend').val()
    //     }
    // });
});
