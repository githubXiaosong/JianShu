<?php

function rq($key = null)
{
    return ($key == null) ? \Illuminate\Support\Facades\Request::all() : \Illuminate\Support\Facades\Request::get($key);
}

function suc($data = null)
{
    $ram = ['status' => 0];
    if ($data) {
        $ram['data'] = $data;
        return $ram;
    }
    return $ram;
}

function err($code, $data = null)
{
    if ($data)
        return ['status' => $code, 'data' => $data];
    return ['status' => $code];
}


Route::group(['middleware' => 'web'], function () {

    Route::get('home', 'PageController@postList');

    Route::group(['prefix' => 'page'], function () {
        Route::get('postList', 'PageController@postList');
        Route::get('postDetail/{post_id}', 'PageController@postDetail');
        Route::get('postAdd', 'PageController@postAdd');//todo Add Auth Check
        Route::get('postEdit/{post_id}', 'PageController@postEdit');//todo Add Auth Check
        Route::get('login', 'PageController@login');
        Route::get('register', 'PageController@register');
        Route::get('userSetting', 'PageController@userSetting');
    });

    Route::group(['prefix' => 'api'], function () {
        Route::post('postAdd', 'ApiController@postAdd');
        Route::post('postEdit', 'ApiController@postEdit');
        Route::get('postDel/{post_id}', 'ApiController@postDel');
        Route::post('postImageUpload', 'ApiController@postImageUpload');
        Route::post('login', 'ApiController@login');
        Route::get('logout', 'ApiController@logout');
        Route::post('register', 'ApiController@register');
        Route::post('userSetting', 'ApiController@userSetting');
        Route::post('commentAdd', 'ApiController@commentAdd');
        Route::get('zan/{post_id}', 'ApiController@zan');
        Route::get('unZan/{post_id}', 'ApiController@unZan');
    });


    Route::group(['prefix' => 'admin'], function () {

        Route::group(['prefix' => 'page'], function () {

        });

        Route::group(['prefix' => 'api'], function () {

        });

    });

});

