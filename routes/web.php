<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});
Route::group(['prefix'=>'errors'],function(){
    Route::get('error500','Helpers\WebHelperController@error500')->name('error.500');
    Route::get('error404','Helpers\WebHelperController@error404')->name('error.404');
});
Route::get('index-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('log');
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth'] ], function() {
    Route::group(['prefix' => 'upload'], function () {
        Route::post('file', "Api\V1\UploadFileController@uploadFile")->name('upload_file');
    });
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function() {
        Route::group(['prefix' => 'artikel','namespace'=>'Artikel', 'as' => 'dashboard.artikel.'], function () {
            Route::get('/','ArtikelController@index')->name('index');
            Route::get('data','ArtikelController@data')->name('data');
            Route::get('create','ArtikelController@create')->name('create');
            Route::get('edit/{id}','ArtikelController@edit')->name('edit');
            Route::delete('delete/{id}','ArtikelController@destroy')->name('destroy');  
            Route::post('delete-json','ArtikelController@destroyJson')->name('destroy-json'); 
            Route::post('store','ArtikelController@store')->name('store'); 
            Route::put('update/{id}','ArtikelController@update')->name('update');
            Route::get('detail/{id}','ArtikelController@detail')->name('detail'); 
            Route::get('detail-json/{id}','ArtikelController@detailJson')->name('detail-json');
        });
        Route::group(['prefix' => 'user-management', 'namespace' => 'User'], function() {
            Route::get('index','UserController@index')->name('dashboard.user.index');
            Route::get('data','UserController@data')->name('dashboard.user.data');
            Route::get('create','UserController@create')->name('dashboard.user.create');
            Route::get('edit/{id}','UserController@edit')->name('dashboard.user.edit');
            Route::delete('delete/{id}','UserController@destroy')->name('dashboard.user.destroy');  
            Route::post('delete-json','UserController@destroyJson')->name('dashboard.user.destroy-json'); 
            Route::post('store','UserController@store')->name('dashboard.user.store'); 
            Route::post('update/{id}','UserController@update')->name('dashboard.user.update');
            Route::get('detail/{id}','UserController@detail')->name('dashboard.user.detail'); 
            Route::get('detail-json/{id}','UserController@detailJson')->name('dashboard.user.detail-json');
        });
        Route::group(['prefix' => 'notifikasi-broadcast','as'=>'dashboard.notifikasi_broadcast.'], function() {
            Route::get('/','NotifikasiController@index')->name('index');
            Route::get('data-user','NotifikasiController@getDataCustomer')->name('data_customer');
            Route::get('history-broadcast','NotifikasiController@getHistoryBroadcast')->name('history_broadcast');
            Route::post('send','NotifikasiController@sendBroadcast')->name('send');
            Route::get('detail/{id}','NotifikasiController@getDetailBroadcast')->name('detail');


        
        });
        Route::group(['prefix' => 'master', 'namespace' => 'Master','as'=>'dashboard.master.'], function() {
            Route::group(['prefix' => 'role','as'=>'role.'], function() {
                Route::get('index','RoleController@index')->name('index');
                Route::get('data','RoleController@data')->name('data');
                Route::get('datatable','RoleController@datatable')->name('datatable');
                Route::get('create','RoleController@create')->name('create');
                Route::get('edit/{id}','RoleController@edit')->name('edit');
                Route::match(['get', 'delete','post'],'delete/{id}','RoleController@destroy')->name('destroy');  
                Route::post('delete-json','RoleController@destroyJson')->name('destroy-json'); 
                Route::post('store','RoleController@store')->name('store'); 
                Route::put('update/{id}','RoleController@update')->name('update');
                Route::get('detail/{id}','RoleController@detail')->name('detail'); 
                Route::get('detail-json/{id}','RoleController@detailJson')->name('detail-json');
            
            });
            Route::group(['prefix' => 'permission','as'=>'permission.'], function() {
                Route::get('index','PermissionController@index')->name('index');
                Route::get('data','PermissionController@data')->name('data');
                Route::get('datatable','PermissionController@datatable')->name('datatable');
                Route::get('create','PermissionController@create')->name('create');
                Route::get('edit/{id}','PermissionController@edit')->name('edit');
                Route::match(['get', 'delete','post'], 'delete/{id}','PermissionController@destroy')->name('destroy');  
                Route::post('delete-json','PermissionController@destroyJson')->name('destroy-json'); 
                Route::post('store','PermissionController@store')->name('store'); 
                Route::put('update/{id}','PermissionController@update')->name('update');
                Route::get('detail/{id}','PermissionController@detail')->name('detail'); 
                Route::get('detail-json/{id}','PermissionController@detailJson')->name('detail-json');
            
            });
            
        });
        Route::group(['prefix' => 'profile-management', 'namespace' => 'User'], function() {
            Route::get('index','ProfileController@index')->name('dashboard.profil.index');
            Route::get('edit','ProfileController@edit')->name('dashboard.profil.edit');
            Route::post('update','ProfileController@update')->name('dashboard.profil.update');
            Route::get('change-password','ProfileController@changePassword')->name('dashboard.profil.change-password');
            Route::post('update-password','ProfileController@updatePassword')->name('dashboard.profil.edit-password');
            
        });
        Route::group(['prefix' => 'config', 'as' =>'dashboard.config.'], function () {
            Route::get('log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('log');
        });
        Route::group(['prefix' => 'master', 'namespace' => 'Master','as'=>'dashboard.master.'], function() {
            // Route::group(['prefix' => 'pendidikan','as'=>'pendidikan.'], function() {
            //     Route::get('index','PendidikanController@index')->name('index');
            //     Route::get('data','PendidikanController@data')->name('data');
            //     Route::get('datatable','PendidikanController@datatable')->name('datatable');
            //     Route::get('create','PendidikanController@create')->name('create');
            //     Route::get('edit/{id}','PendidikanController@edit')->name('edit');
            //     Route::match(['get', 'delete','post'],'delete/{id}','PendidikanController@destroy')->name('destroy');  
            //     Route::post('delete-json','PendidikanController@destroyJson')->name('destroy-json'); 
            //     Route::post('store','PendidikanController@store')->name('store'); 
            //     Route::match(['get', 'delete','put'],'update/{id}','PendidikanController@update')->name('update');
            //     Route::get('detail/{id}','PendidikanController@detail')->name('detail'); 
            //     Route::get('detail-json/{id}','PendidikanController@detailJson')->name('detail-json');
            
            // });
            // Route::group(['prefix' => 'pekerjaan','as'=>'pekerjaan.'], function() {
            //     Route::get('index','PekerjaanController@index')->name('index');
            //     Route::get('data','PekerjaanController@data')->name('data');
            //     Route::get('datatable','PekerjaanController@datatable')->name('datatable');
            //     Route::get('create','PekerjaanController@create')->name('create');
            //     Route::get('edit/{id}','PekerjaanController@edit')->name('edit');
            //     Route::match(['get', 'delete','post'],'delete/{id}','PekerjaanController@destroy')->name('destroy');  
            //     Route::post('delete-json','PekerjaanController@destroyJson')->name('destroy-json'); 
            //     Route::post('store','PekerjaanController@store')->name('store'); 
            //     Route::match(['get', 'delete','put'],'update/{id}','PekerjaanController@update')->name('update');
            //     Route::get('detail/{id}','PekerjaanController@detail')->name('detail'); 
            //     Route::get('detail-json/{id}','PekerjaanController@detailJson')->name('detail-json');
            
            // });
            
            // Route::group(['prefix' => 'jamaah', 'as' => 'jamaah.'], function () {
            //     Route::get('index','JamaahController@index')->name('index');
            //     Route::get('data','JamaahController@data')->name('data');
            //     Route::get('datatable','JamaahController@datatable')->name('datatable');
            //     Route::get('create','JamaahController@create')->name('create');
            //     Route::get('edit/{id}','JamaahController@edit')->name('edit');
            //     Route::match(['get', 'delete','post'],'delete/{id}','JamaahController@destroy')->name('destroy');  
            //     Route::post('delete-json','JamaahController@destroyJson')->name('destroy-json'); 
            //     Route::post('store','JamaahController@store')->name('store'); 
            //     Route::match(['get', 'delete','put'],'update/{id}','JamaahController@update')->name('update');
            //     Route::get('detail/{id}','JamaahController@detail')->name('detail'); 
            //     Route::get('detail-json/{id}','JamaahController@detailJson')->name('detail-json');
            // });
            // Route::group(['prefix' => 'kbih', 'as' => 'kbih.'], function () {
            //     Route::get('index','KbihController@index')->name('index');
            //     Route::get('data','KbihController@data')->name('data');
            //     Route::get('datatable','KbihController@datatable')->name('datatable');
            //     Route::get('create','KbihController@create')->name('create');
            //     Route::get('edit/{id}','KbihController@edit')->name('edit');
            //     Route::match(['get', 'delete','post'],'delete/{id}','KbihController@destroy')->name('destroy');  
            //     Route::post('delete-json','KbihController@destroyJson')->name('destroy-json'); 
            //     Route::post('store','KbihController@store')->name('store'); 
            //     Route::match(['get', 'delete','put'],'update/{id}','KbihController@update')->name('update');
            //     Route::get('detail/{id}','KbihController@detail')->name('detail'); 
            //     Route::get('detail-json/{id}','KbihController@detailJson')->name('detail-json');
            // });
            Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
                Route::get('index','PembayaranController@index')->name('index');
                Route::get('data','PembayaranController@data')->name('data');
                Route::get('datatable','PembayaranController@datatable')->name('datatable');
                Route::get('create','PembayaranController@create')->name('create');
                Route::get('edit/{id}','PembayaranController@edit')->name('edit');
                Route::match(['get', 'delete','post'],'delete/{id}','PembayaranController@destroy')->name('destroy');  
                Route::post('delete-json','PembayaranController@destroyJson')->name('destroy-json'); 
                Route::post('store','PembayaranController@store')->name('store'); 
                Route::match(['get', 'delete','put'],'update/{id}','PembayaranController@update')->name('update');
                Route::get('detail/{id}','PembayaranController@detail')->name('detail'); 
                Route::get('detail-json/{id}','PembayaranController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'faq', 'as' => 'faq.'], function () {
                             
                Route::get('index','FaqController@index')->name('index');
                Route::get('datatable','FaqController@datatable')->name('datatable');
                Route::get('create','FaqController@create')->name('create');
                Route::get('edit/{id}','FaqController@edit')->name('edit');
                Route::delete('delete/{id}','FaqController@destroy')->name('destroy');  
                Route::post('delete-json','FaqController@destroyJson')->name('destroy-json'); 
                Route::post('store','FaqController@store')->name('store'); 
                Route::post('update/{id}','FaqController@update')->name('update');
                Route::get('detail/{id}','FaqController@detail')->name('detail'); 
                Route::get('detail-json/{id}','FaqController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'mitra-travel', 'as' => 'mitra-travel.'], function () {
                             
                Route::get('index','MitraTravelController@index')->name('index');
                Route::get('datatable','MitraTravelController@datatable')->name('datatable');
                Route::get('create','MitraTravelController@create')->name('create');
                Route::get('edit/{id}','MitraTravelController@edit')->name('edit');
                Route::delete('delete/{id}','MitraTravelController@destroy')->name('destroy');  
                Route::post('delete-json','MitraTravelController@destroyJson')->name('destroy-json'); 
                Route::post('store','MitraTravelController@store')->name('store'); 
                Route::post('update/{id}','MitraTravelController@update')->name('update');
                Route::get('detail/{id}','MitraTravelController@detail')->name('detail'); 
                Route::get('detail-json/{id}','MitraTravelController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'info-slider', 'as' => 'info-slider.'], function () {
                             
                Route::get('index','BannerController@index')->name('index');
                Route::get('datatable','BannerController@datatable')->name('datatable');
                Route::get('create','BannerController@create')->name('create');
                Route::get('edit/{id}','BannerController@edit')->name('edit');
                Route::delete('delete/{id}','BannerController@destroy')->name('destroy');  
                Route::post('delete-json','BannerController@destroyJson')->name('destroy-json'); 
                Route::post('store','BannerController@store')->name('store'); 
                Route::post('update/{id}','BannerController@update')->name('update');
                Route::get('detail/{id}','BannerController@detail')->name('detail'); 
                Route::get('detail-json/{id}','BannerController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'syarat-ketentuan', 'as' => 'syarat-ketentuan.'], function () {
                             
                Route::get('index','SyaratKetentuanController@index')->name('index');
                Route::get('datatable','SyaratKetentuanController@datatable')->name('datatable');
                Route::get('create','SyaratKetentuanController@create')->name('create');
                Route::get('edit/{id}','SyaratKetentuanController@edit')->name('edit');
                Route::delete('delete/{id}','SyaratKetentuanController@destroy')->name('destroy');  
                Route::post('delete-json','SyaratKetentuanController@destroyJson')->name('destroy-json'); 
                Route::post('store','SyaratKetentuanController@store')->name('store'); 
                Route::post('update/{id}','SyaratKetentuanController@update')->name('update');
                Route::get('detail/{id}','SyaratKetentuanController@detail')->name('detail'); 
                Route::get('detail-json/{id}','SyaratKetentuanController@detailJson')->name('detail-json');
            });
           
            
        });
        Route::group(['prefix' => 'inspirasi', 'namespace' => 'Inspirasi','as' =>'dashboard.inspirasi.'], function () {
            Route::group(['prefix' => 'bacaan', 'as' => 'bacaan.'], function () {
                             
                Route::get('index','BacaanController@index')->name('index');
                Route::get('datatable','BacaanController@datatable')->name('datatable');
                Route::get('create','BacaanController@create')->name('create');
                Route::get('edit/{id}','BacaanController@edit')->name('edit');
                Route::delete('delete/{id}','BacaanController@destroy')->name('destroy');  
                Route::post('delete-json','BacaanController@destroyJson')->name('destroy-json'); 
                Route::post('store','BacaanController@store')->name('store'); 
                Route::post('update/{id}','BacaanController@update')->name('update');
                Route::get('detail/{id}','BacaanController@detail')->name('detail'); 
                Route::get('detail-json/{id}','BacaanController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'podcast', 'as' => 'podcast.'], function () {
                             
                Route::get('index','PodcastController@index')->name('index');
                Route::get('datatable','PodcastController@datatable')->name('datatable');
                Route::get('create','PodcastController@create')->name('create');
                Route::get('edit/{id}','PodcastController@edit')->name('edit');
                Route::delete('delete/{id}','PodcastController@destroy')->name('destroy');  
                Route::post('delete-json','PodcastController@destroyJson')->name('destroy-json'); 
                Route::post('store','PodcastController@store')->name('store'); 
                Route::post('update/{id}','PodcastController@update')->name('update');
                Route::get('detail/{id}','PodcastController@detail')->name('detail'); 
                Route::get('detail-json/{id}','PodcastController@detailJson')->name('detail-json');
            });
            Route::group(['prefix' => 'video', 'as' => 'video.'], function () {
                             
                Route::get('index','VideoController@index')->name('index');
                Route::get('datatable','VideoController@datatable')->name('datatable');
                Route::get('create','VideoController@create')->name('create');
                Route::get('edit/{id}','VideoController@edit')->name('edit');
                Route::delete('delete/{id}','VideoController@destroy')->name('destroy');  
                Route::post('delete-json','VideoController@destroyJson')->name('destroy-json'); 
                Route::post('store','VideoController@store')->name('store'); 
                Route::post('update/{id}','VideoController@update')->name('update');
                Route::get('detail/{id}','VideoController@detail')->name('detail'); 
                Route::get('detail-json/{id}','VideoController@detailJson')->name('detail-json');
            });
        });

        Route::group(['prefix' => 'paket-tabungan', 'namespace' => 'PaketTabungan','as' =>'dashboard.paket-tabungan.'], function () {


            Route::group(['prefix' => 'haji', 'as' => 'haji.','namespace' => 'Haji'], function () {
                             
                Route::get('index','PaketTabunganController@index')->name('index');
                Route::get('datatable','PaketTabunganController@datatable')->name('datatable');
                Route::get('create','PaketTabunganController@create')->name('create');
                Route::get('edit/{id}','PaketTabunganController@edit')->name('edit');
                Route::delete('delete/{id}','PaketTabunganController@destroy')->name('destroy');  
                Route::post('delete-json','PaketTabunganController@destroyJson')->name('destroy-json'); 
                Route::post('store','PaketTabunganController@store')->name('store'); 
                Route::post('update/{id}','PaketTabunganController@update')->name('update');
                Route::get('detail/{id}','PaketTabunganController@detail')->name('detail'); 
                Route::get('detail-json/{id}','PaketTabunganController@detailJson')->name('detail-json');

            });

            Route::group(['prefix' => 'umrah', 'as' => 'umrah.','namespace' => 'Umrah'], function () {
                             
                Route::get('index','PaketTabunganController@index')->name('index');
                Route::get('datatable','PaketTabunganController@datatable')->name('datatable');
                Route::get('create','PaketTabunganController@create')->name('create');
                Route::get('edit/{id}','PaketTabunganController@edit')->name('edit');
                Route::delete('delete/{id}','PaketTabunganController@destroy')->name('destroy');  
                Route::post('delete-json','PaketTabunganController@destroyJson')->name('destroy-json'); 
                Route::post('store','PaketTabunganController@store')->name('store'); 
                Route::post('update/{id}','PaketTabunganController@update')->name('update');
                Route::get('detail/{id}','PaketTabunganController@detail')->name('detail'); 
                Route::get('detail-json/{id}','PaketTabunganController@detailJson')->name('detail-json');
            });
        });
        
    });
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'image','middleware'=>['auth'],'namespace'=>'Api\V1'], function () {
    Route::post('upload', "UploadFileController@uploadFile")->name('upload_image');
});


