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

Route::group(['prefix' => 'blog-mockup', 'namespace' => 'Blog', 'as'=>'blog.mockup.'], function () {
    Route::get('index', "BlogMockupController@index")->name('index');
    Route::get('blog', "BlogMockupController@blog")->name('blog');
    Route::get('post', "BlogMockupController@post")->name('post');
});
Route::group([ 'namespace' => 'Blog', 'as'=>'blog.'], function () {
    Route::get('index', "BlogController@index")->name('index');
    Route::get('blog', "BlogController@blog")->name('blog');
    Route::get('post/{id}', "BlogController@detail")->name('post');
});
Route::group([ 'prefix' => 'comment','namespace' => 'Blog', 'as'=>'comment.'], function () {
    Route::get('get-by-post/{postId}', "BlogController@listComment")->name('get-by-post');
    Route::get('submit/{postId}', "BlogController@submitComment")->name('submit-by-post');
    
});


Route::group(['middleware' => ['auth'] ], function() {
    Route::group(['prefix' => 'upload'], function () {
        Route::post('file', "Api\V1\UploadFileController@uploadFile")->name('upload_file');
    });
    Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard','as'=>'dashboard.'], function() {
        Route::group(['as'=>'post.'], function() {
            Route::get('index','PostController@index')->name('index');
            Route::get('data','PostController@data')->name('data');
            Route::get('datatable','PostController@datatable')->name('datatable');
            Route::get('create','PostController@create')->name('create');
            Route::get('edit/{id}','PostController@edit')->name('edit');
            Route::match(['get', 'delete','post'],'delete/{id}','PostController@destroy')->name('destroy');  
            Route::post('delete-json','PostController@destroyJson')->name('destroy-json'); 
            Route::post('store','PostController@store')->name('store'); 
            Route::match(['get', 'delete','put'],'update/{id}','PostController@update')->name('update');
            Route::get('detail/{id}','PostController@detail')->name('detail'); 
            Route::get('detail-json/{id}','PostController@detailJson')->name('detail-json');
        });
        Route::group(['as'=>'category.'], function() {
            Route::get('index','CategoryController@index')->name('index');
            Route::get('data','CategoryController@data')->name('data');
            Route::get('datatable','CategoryController@datatable')->name('datatable');
            Route::get('create','CategoryController@create')->name('create');
            Route::get('edit/{id}','CategoryController@edit')->name('edit');
            Route::match(['get', 'delete','post'],'delete/{id}','CategoryController@destroy')->name('destroy');  
            Route::post('delete-json','CategoryController@destroyJson')->name('destroy-json'); 
            Route::post('store','CategoryController@store')->name('store'); 
            Route::match(['get', 'delete','put'],'update/{id}','CategoryController@update')->name('update');
            Route::get('detail/{id}','CategoryController@detail')->name('detail'); 
            Route::get('detail-json/{id}','CategoryController@detailJson')->name('detail-json');
            
        });
        Route::group(['as'=>'master.'], function() {
        
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
                Route::group(['prefix' => 'pendidikan','as'=>'pendidikan.'], function() {
                    Route::get('index','PendidikanController@index')->name('index');
                    Route::get('data','PendidikanController@data')->name('data');
                    Route::get('datatable','PendidikanController@datatable')->name('datatable');
                    Route::get('create','PendidikanController@create')->name('create');
                    Route::get('edit/{id}','PendidikanController@edit')->name('edit');
                    Route::match(['get', 'delete','post'],'delete/{id}','PendidikanController@destroy')->name('destroy');  
                    Route::post('delete-json','PendidikanController@destroyJson')->name('destroy-json'); 
                    Route::post('store','PendidikanController@store')->name('store'); 
                    Route::match(['get', 'delete','put'],'update/{id}','PendidikanController@update')->name('update');
                    Route::get('detail/{id}','PendidikanController@detail')->name('detail'); 
                    Route::get('detail-json/{id}','PendidikanController@detailJson')->name('detail-json');
                
                });
                Route::group(['prefix' => 'pekerjaan','as'=>'pekerjaan.'], function() {
                    Route::get('index','PekerjaanController@index')->name('index');
                    Route::get('data','PekerjaanController@data')->name('data');
                    Route::get('datatable','PekerjaanController@datatable')->name('datatable');
                    Route::get('create','PekerjaanController@create')->name('create');
                    Route::get('edit/{id}','PekerjaanController@edit')->name('edit');
                    Route::match(['get', 'delete','post'],'delete/{id}','PekerjaanController@destroy')->name('destroy');  
                    Route::post('delete-json','PekerjaanController@destroyJson')->name('destroy-json'); 
                    Route::post('store','PekerjaanController@store')->name('store'); 
                    Route::match(['get', 'delete','put'],'update/{id}','PekerjaanController@update')->name('update');
                    Route::get('detail/{id}','PekerjaanController@detail')->name('detail'); 
                    Route::get('detail-json/{id}','PekerjaanController@detailJson')->name('detail-json');
                
                });
               
                
            });
            
            
            
        });


    });
    
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'image','middleware'=>['auth'],'namespace'=>'Api\V1'], function () {
    Route::post('upload', "UploadFileController@uploadFile")->name('upload_image');
});


