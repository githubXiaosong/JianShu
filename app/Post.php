<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];// 不可以使用数组注入的字段 如果设置成数组 那么代表所有传递过来的数据都可以设置进去

    //protected $fillable = [];// 可以使用数组注入的字段

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    public function zans()
    {
        return $this->hasMany('App\Zan')->orderBy('created_at', 'desc');
    }



}
