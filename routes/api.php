<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'activity-record', 'namespace' => 'Api'], function() {
    Route::post('create', 'ActivityRecordController@create');
    Route::post('all', 'ActivityRecordController@all');
});
Route::group(['prefix' => 'v1', 'namespace' => 'Api\V1', 'middleware' => ['save.deviceinfo']], function() {
    Route::group(['prefix' => 'autentikasi', 'namespace' => 'Autentikasi'], function() {
        Route::post('signin', 'AutentikasiController@signin');
        Route::post('signin-firebase', 'AutentikasiController@signinFirebase');
        Route::post('signin-bypass', 'AutentikasiController@signinBypass');
        Route::post('signout', 'AutentikasiController@signout')->middleware('auth:api');
        Route::post('signup', 'AutentikasiController@signup');
        Route::post('signup-confirmation', 'AutentikasiController@signupConfirmation');
        Route::post('reset-password', 'AutentikasiController@resetPassword');
        Route::post('reset-password-confirmation', 'AutentikasiController@resetPasswordConfirmation');
        Route::get('all-user', 'AutentikasiController@allUser');
    });
    Route::group(['prefix' => 'confirmation', 'namespace' => 'Autentikasi'], function() {
        Route::post('send', 'ConfirmationController@send');
        Route::post('verify', 'ConfirmationController@verify');
    });
    Route::group(['prefix' => 'cryptography'], function() {
        Route::post('encrypt', 'CryptographyController@encrypt');
        Route::post('decrypt', 'CryptographyController@decrypt');
        Route::post('test', 'CryptographyController@test')->middleware('api.decrypt');
    });
    Route::group(['prefix' => 'crawler', 'namespace' => 'Crawler'], function() {
        Route::group(['prefix' => 'cms'], function() {
            Route::get('login', 'CMSCrawlerController@login');
        });
    });
    Route::group(['prefix' => 'profile', 'middleware' => ['auth:api'], 'namespace' => 'Profile'], function() {
        Route::group(['prefix' => 'notifikasi'], function() {
            Route::post('create', 'NotifikasiController@create');
            Route::post('all', 'NotifikasiController@all');
            Route::post('send-to-all', 'NotifikasiController@sendToAll');
        });
        Route::group(['prefix' => 'util', 'namespace' => 'Util'], function() {
            Route::post('pull', 'UtilController@pull');
            Route::post('info', 'UtilController@info');
        });
        Route::get('get', 'ProfileController@get');
        Route::post('get', 'ProfileController@get');
        Route::post('update', 'ProfileController@update');
       
        Route::post('change-password', 'ProfileController@changePassword');
        Route::post('change-username', 'ProfileController@changeUsername');
        Route::post('change-username-confirmation', 'ProfileController@changeUsernameConfirmation');
        Route::post('activity-records', 'ProfileController@activityRecords');
        Route::post('send-email', 'ProfileController@sendEmail');
        Route::post('send-sms', 'ProfileController@sendSms');
       
    });
    Route::group(['prefix' => 'file', 'middleware' => ['auth:api'], 'namespace' => 'File'], function() {
        Route::post('upload', 'FileController@upload');
        Route::get('myfiles', 'FileController@myFiles');
    });

    // Note: di comment soalnya file UserRecordController nggak ada
    // Route::group(['prefix' => 'record', 'middleware' => ['auth:api'], 'namespace' => 'UserRecord'], function() {
    //     Route::post('gets', 'UserRecordController@gets');
    // });

   
    Route::group(['prefix' => 'user', 'middleware' => ['auth:api'], 'namespace' => 'User'], function() {
        Route::post('all', 'KelolaUserController@all');
        Route::post('get', 'KelolaUserController@get');
        Route::post('create', 'KelolaUserController@create');
        Route::post('set-role', 'KelolaUserController@setRole');
    });
    

    Route::post('upload-image', "UploadFileController@uploadFile")->middleware('auth:api');

    Route::group(['prefix' => 'master','namespace'=>'Master'], function () {
       
        //group api butuh login
        Route::group(['middleware' => ['auth:api']], function () {
           
        });
       
        Route::group(['prefix' => 'pekerjaan'], function () {
            Route::get('get','MasterPekerjaanController@get');
            
        });
        Route::group(['prefix' => 'pendidikan'], function () {
            Route::get('get','MasterPendidikanController@get');
        });

        Route::get('provinces','AreaController@get_provinsi');
        Route::post('provinces','AreaController@get_provinsi');
        Route::get('cities/{provinsi_id}','AreaController@get_kota');
        Route::post('cities/{provinsi_id}','AreaController@get_kota');
        Route::get('cities-all','AreaController@get_kota_all');
        Route::post('cities-all','AreaController@get_kota_all');
        Route::get('kecamatans/{kota_id}','AreaController@get_kecamatan');
        Route::post('kecamatans/{kota_id}','AreaController@get_kecamatan');
        Route::get('kelurahans/{kecatamatan_id}','AreaController@get_kelurahan');
        Route::post('kelurahans/{kecatamatan_id}','AreaController@get_kelurahan');
    });
});
