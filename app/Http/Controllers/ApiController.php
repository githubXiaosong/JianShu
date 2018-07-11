<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function postAdd()
    {

        $validator = Validator::make(rq(), [
            'title' => 'required|string|min:5|max:100',
            'content' => 'required|string|min:10'
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->messages());


        $post = new Post();
        $post->user_id = \Auth::id();
        $post->title = rq('title');
        $post->content = rq('content');

        $post->save();

        return back();
    }

    public function postDel($id)
    {
        $post = Post::find($id);

        if (auth()->user()->can('delete', $post)) {
            $post->delete();
        }

        return redirect('page/postList');
    }

    public function postEdit()
    {
        $validator = Validator::make(rq(), [
            'title' => 'required|string|min:5|max:100',
            'content' => 'required|string|min:10'
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->messages());


        $post = Post::find(rq('id'));

        if (auth()->user()->can('update', $post)) {
            $post->title = rq('title');
            $post->content = rq('content');

            $post->save();
        }

        return back();
    }


    public function postImageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/' . $path);
    }


    public function register()
    {
        $validator = Validator::make(rq(), [
            'name' => 'required|min:5|max:20|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:10|confirmed'
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->messages());

        $user = new User();
        $user->name = rq('name');
        $user->password = bcrypt(rq('password'));
        $user->email = rq('email');
        $user->save();

        return redirect('page/login');
    }

    public function login()
    {
        $validator = Validator::make(rq(), [
            'email' => 'required|email',
            'password' => 'required|min:5,max:10',
            'is_remember' => 'integer'
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->messages());

        $user = request(['email', 'password']);
        $is_remember = boolval(rq('is_remember'));
        if (\Auth::attempt($user, $is_remember)) {
            return redirect('page/postList');
        }

        return back()->withErrors('邮箱和密码不匹配');
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/page/login');
    }

    public function userSetting()
    {

    }

    public function commentAdd()
    {
        $validator = Validator::make(rq(), [
            'content' => 'required|min:5|max:200|',
        ]);
        if ($validator->fails())
            return back()->withErrors($validator->messages());

        $comment = new Comment();

        $comment->user_id = auth()->id();
        $comment->post_id = rq('post_id');
        $comment->content = rq('content');
        $comment->save();

        return back();
    }

    public function zan($post_id)
    {
        $user_id = auth()->id();

        $zan = Zan::where(['user_id' => $user_id, 'post_id' => $post_id])->first();

        if (!$zan) {
            $zan = new Zan();
            $zan->user_id = $user_id;
            $zan->post_id = $post_id;
            $zan->save();
        }
        return back();
    }

    public function unZan($post_id)
    {

        $user_id = auth()->id();
        Zan::where([
            'user_id' => $user_id,
            'post_id' => $post_id
        ])->delete();

        return back();

    }
}
