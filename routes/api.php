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
        Route::post('generate-number-id', 'ProfileController@generateNumberId');
        Route::post('saldo', 'ProfileController@saldo');
        Route::post('change-password', 'ProfileController@changePassword');
        Route::post('change-username', 'ProfileController@changeUsername');
        Route::post('change-username-confirmation', 'ProfileController@changeUsernameConfirmation');
        Route::post('activity-records', 'ProfileController@activityRecords');
        Route::post('send-email', 'ProfileController@sendEmail');
        Route::post('send-sms', 'ProfileController@sendSms');
        Route::group(['prefix' => 'review', 'namespace' => 'Review'], function() {
            Route::post('create', 'ReviewController@create');
            Route::post('update', 'ReviewController@update');
            Route::post('delete', 'ReviewController@delete');
            Route::post('get', 'ReviewController@get');
            Route::post('all', 'ReviewController@all');
            Route::group(['prefix' => 'comment'], function() {
                Route::post('create', 'ReviewCommentController@create');
                Route::post('delete', 'ReviewCommentController@delete');
            });
            Route::group(['prefix' => 'like'], function() {
                Route::post('create', 'ReviewLikeController@create');
                Route::post('delete', 'ReviewLikeController@delete');
            });
        });
    });
    Route::group(['prefix' => 'file', 'middleware' => ['auth:api'], 'namespace' => 'File'], function() {
        Route::post('upload', 'FileController@upload');
        Route::get('myfiles', 'FileController@myFiles');
    });

    // Note: di comment soalnya file UserRecordController nggak ada
    // Route::group(['prefix' => 'record', 'middleware' => ['auth:api'], 'namespace' => 'UserRecord'], function() {
    //     Route::post('gets', 'UserRecordController@gets');
    // });

    Route::group(['prefix' => 'haji', 'middleware' => ['auth:api'], 'namespace' => 'Haji'], function() {
        Route::group(['prefix' => 'daftar-haji'], function() {
            Route::post('create', 'DaftarHajiController@create');
            Route::post('update', 'DaftarHajiController@update');
            Route::post('delete', 'DaftarHajiController@delete');
            Route::post('get', 'DaftarHajiController@get');
            Route::post('gets', 'DaftarHajiController@gets');
            Route::post('all', 'DaftarHajiController@all');
            Route::post('upload-lampiran', 'DaftarHajiController@uploadLampiran');
        });
        Route::group(['prefix' => 'status-daftar-haji'], function () {
            Route::post('all','StatusDaftarHajiController@all');
            Route::post('availables','StatusDaftarHajiController@availables');
            Route::post('update','StatusDaftarHajiController@update');
            Route::post('logs','StatusDaftarHajiController@logs');
        });
        Route::group(['prefix' => 'admin'], function() {
            Route::post('total-by-status', 'DaftarHajiAdminController@totalByStatus');
            Route::post('gets-by-status', 'DaftarHajiAdminController@getsByStatus');
        });
        Route::group(['prefix' => 'kbih'], function() {
            Route::post('update', 'DaftarHajiKbihController@update');
            Route::post('get', 'DaftarHajiKbihController@get');
            Route::post('gets', 'DaftarHajiKbihController@gets');
            Route::post('upload-lampiran', 'DaftarHajiKbihController@uploadLampiran');
        });
        Route::group(['prefix' => 'pembayaran'], function() {
            Route::post('create', 'PembayaranHajiController@create');
            Route::post('update', 'PembayaranHajiController@update');
            Route::post('delete', 'PembayaranHajiController@delete');
            Route::post('get', 'PembayaranHajiController@get');
            Route::post('gets', 'PembayaranHajiController@gets');
        });
    });
    Route::group(['prefix' => 'nasabah', 'middleware' => ['auth:api'], 'namespace' => 'Nasabah'], function() {
        Route::post('create', 'NasabahController@create');
        Route::post('update', 'NasabahController@update');
        Route::post('delete', 'NasabahController@delete');
        Route::post('get', 'NasabahController@get');
        Route::post('get-by-va', 'NasabahController@getByVa');
        Route::post('gets', 'NasabahController@gets');
        Route::post('all', 'NasabahController@all');

        Route::post('get-token', 'NasabahController@getToken');
        Route::post('create-va', 'NasabahController@createVA');
    });
    Route::group(['prefix' => 'artikel', 'middleware' => ['auth:api'], 'namespace' => 'Artikel'], function() {
        Route::post('upsert', 'ArtikelController@upsert');
        Route::post('delete', 'ArtikelController@delete');
        Route::post('detail', 'ArtikelController@detail');
        Route::post('all', 'ArtikelController@all');
    });
    Route::group(['prefix' => 'mitra-travel', 'middleware' => ['auth:api'], 'namespace' => 'MitraTravel'], function() {
        Route::post('upsert', 'MitraTravelController@upsert');
        Route::post('delete', 'MitraTravelController@delete');
        Route::post('detail', 'MitraTravelController@detail');
        Route::post('all', 'MitraTravelController@all');
    });
    Route::group(['prefix' => 'inspirasi', 'middleware' => ['auth:api'], 'namespace' => 'Inspirasi'], function() {
        Route::post('upsert', 'InspirasiController@upsert');
        Route::post('delete', 'InspirasiController@delete');
        Route::post('detail', 'InspirasiController@detail');
        Route::post('all', 'InspirasiController@all');
        Route::post('comment', 'InspirasiController@comment');
        Route::post('sub-comment', 'InspirasiController@subComment');
        Route::post('like', 'InspirasiController@like');
        Route::post('view', 'InspirasiController@view');
        Route::post('like-comment', 'InspirasiController@likeComment');
    });
    Route::group(['prefix' => 'pembayaran', 'namespace' => 'Pembayaran'], function() {
        Route::group(['prefix' => 'bms-callback'], function() {
            Route::post('inquiry', 'BMSCallBackController@inquiry');
            Route::post('payment', 'BMSCallBackController@payment');
        });
    });
    Route::group(['prefix' => 'pembayaran', 'middleware' => ['auth:api'], 'namespace' => 'Pembayaran'], function() {
        Route::post('input-tabungan', 'PembayaranController@inputTabungan');
        Route::post('upload-bukti-transfer', 'PembayaranController@uploadBuktiTransfer');
        Route::post('verify', 'PembayaranController@verify');
        Route::post('delete', 'PembayaranController@delete');
        Route::post('get', 'PembayaranController@get');
        Route::post('gets', 'PembayaranController@gets');
        Route::post('all', 'PembayaranController@all');
        Route::post('info-total', 'PembayaranController@infoTotal');
        Route::post('info-total-all', 'PembayaranController@infoTotalAll');
        Route::group(['prefix' => 'point'], function() {
            Route::post('create', 'DumaPointController@create');
            Route::post('delete', 'DumaPointController@delete');
            Route::post('riwayat', 'DumaPointController@riwayat');
            Route::post('info', 'DumaPointController@info');
        });
        Route::group(['prefix' => 'cash'], function() {
            Route::post('create', 'DumaCashController@create');
            Route::post('delete', 'DumaCashController@delete');
            Route::post('riwayat', 'DumaCashController@riwayat');
            Route::post('info', 'DumaCashController@info');
        });
        Route::post('login-bms', 'PembayaranController@loginBms');
    });
    Route::group(['prefix' => 'user', 'middleware' => ['auth:api'], 'namespace' => 'User'], function() {
        Route::post('all', 'KelolaUserController@all');
        Route::post('get', 'KelolaUserController@get');
        Route::post('create', 'KelolaUserController@create');
        Route::post('set-role', 'KelolaUserController@setRole');
    });
    Route::group(['prefix' => 'perusahaan', 'middleware' => ['auth:api'], 'namespace' => 'Perusahaan'], function() {
        Route::group(['prefix' => 'rekening', 'middleware' => 'auth:api'], function() {
            Route::post('create', 'RekeningPerusahaanController@create');
            Route::post('update', 'RekeningPerusahaanController@update');
            Route::post('delete', 'RekeningPerusahaanController@delete');
            Route::post('all', 'RekeningPerusahaanController@all');
            Route::post('available', 'RekeningPerusahaanController@available');
        });
    });
    Route::group(['prefix' => 'haji-muda', 'middleware' => ['auth:api'], 'namespace' => 'HajiMuda'], function() {
        Route::group(['prefix' => 'paket'], function() {
            Route::post('upsert', 'PaketHajiMudaController@upsert');
            Route::post('delete', 'PaketHajiMudaController@delete');
            Route::post('detail', 'PaketHajiMudaController@detail');
            Route::post('all', 'PaketHajiMudaController@all');
        });
    });
    Route::group(['prefix' => 'tabungan', 'middleware' => ['auth:api'], 'namespace' => 'Tabungan'], function() {
        Route::group(['prefix' => 'umrah', 'namespace' => 'Umrah'], function() {
            Route::post('dummy', 'TabunganUmrahController@dummy');
            Route::post('create', 'TabunganUmrahController@create');
            Route::post('update', 'TabunganUmrahController@update');
            Route::post('delete', 'TabunganUmrahController@delete');
            Route::post('get', 'TabunganUmrahController@get');
            Route::post('gets', 'TabunganUmrahController@gets');
            Route::post('all', 'TabunganUmrahController@all');
            Route::post('riwayat', 'TabunganUmrahController@riwayat');
            Route::post('info-total', 'TabunganUmrahController@infoTotal');
            Route::group(['prefix' => 'paket', 'middleware' => 'auth:api'], function() {
                Route::post('create', 'PaketTabunganUmrahController@create');
                Route::post('update', 'PaketTabunganUmrahController@update');
                Route::post('delete', 'PaketTabunganUmrahController@delete');
                Route::post('get', 'PaketTabunganUmrahController@get');
                Route::post('gets', 'PaketTabunganUmrahController@gets');
                Route::post('all', 'PaketTabunganUmrahController@all');
                Route::post('default', 'PaketTabunganUmrahController@default');
            });
        });
        Route::group(['prefix' => 'haji', 'namespace' => 'Haji'], function() {
            Route::post('create', 'TabunganHajiController@create');
            Route::post('update', 'TabunganHajiController@update');
            Route::post('delete', 'TabunganHajiController@delete');
            Route::post('get', 'TabunganHajiController@get');
            Route::post('gets', 'TabunganHajiController@gets');
            Route::post('all', 'TabunganHajiController@all');
            Route::post('riwayat', 'TabunganHajiController@riwayat');
            Route::post('info-total', 'TabunganHajiController@infoTotal');
            Route::group(['prefix' => 'paket', 'middleware' => 'auth:api'], function() {
                Route::post('create', 'PaketTabunganHajiController@create');
                Route::post('update', 'PaketTabunganHajiController@update');
                Route::post('delete', 'PaketTabunganHajiController@delete');
                Route::post('get', 'PaketTabunganHajiController@get');
                Route::post('gets', 'PaketTabunganHajiController@gets');
                Route::post('all', 'PaketTabunganHajiController@all');
                Route::post('default', 'PaketTabunganHajiController@default');
            });
        });
    });

    Route::post('upload-image', "UploadFileController@uploadFile")->middleware('auth:api');

    Route::group(['prefix' => 'master','namespace'=>'Master'], function () {
        Route::group(['prefix' => 'faq'], function () {
            Route::post('gets','FaqController@gets');
        });
        Route::group(['prefix' => 'cara-menabung'], function () {
            Route::post('all','CaraMenabungController@all');
        });
        Route::group(['prefix' => 'info-slider'], function () {
            Route::post('upsert','InfoSliderController@upsert');
            Route::post('delete','InfoSliderController@delete');
            Route::post('detail','InfoSliderController@detail');
            Route::post('all','InfoSliderController@all');
        });
        Route::group(['prefix' => 'sk'], function () {
            Route::post('get','SyaratKetentuanController@get');
            Route::post('all','SyaratKetentuanController@all');
        });
        Route::group(['prefix' => 'notifikasi'], function () {
            Route::post('actions','MasterNotifikasiController@actions');
            Route::post('groups','MasterNotifikasiController@groups');
        });

        //group api butuh login
        Route::group(['middleware' => ['auth:api']], function () {
            Route::group(['prefix' => 'jamaah'], function () {
                Route::get('list','JamaahController@list');
                Route::post('detail','JamaahController@detail');
                Route::post('create','JamaahController@create');
                Route::post('update','JamaahController@update');
                Route::post('upsert','JamaahController@upsert');
            });
        });
        Route::group(['prefix' => 'kbih'], function () {
            Route::get('list','KbihController@list');
            Route::post('list','KbihController@list');
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
