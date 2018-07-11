@extends("layouts.main")

@section("content")


    <div class="col-sm-8 blog-main">
        <div class="blog-post">
            <div style="display:inline-flex">
                <h2 class="blog-post-title">{{$post->title}}</h2>

            </div>

            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a
                        href="#">{{$post->user->name}}</a></p>

            @can('update',$post)
                <a href="{{ url('page/postEdit/'.$post->id) }}"><span>编辑</span></a>
            @endcan
            @can('delete',$post)
                <a href="{{ url('api/postDel/'.$post->id) }}"><span>删除</span></a>
            @endcan
            <p>{!! $post->content !!}</p>
            <div>
                @if(\App\Zan::where(['user_id'=>auth()->id(),'post_id'=>$post->id])->first())
                    <a href="{{ url('api/unZan/'.$post->id) }}" type="button" class="btn btn-default btn-lg">取消赞</a>
                @else
                    <a href="{{ url('api/zan/'.$post->id) }}" type="button" class="btn btn-primary btn-lg">赞</a>
                @endif

            </div>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">评论</div>

            <!-- List group -->
            <ul class="list-group">
                @foreach($post->comments as $comment)
                    <li class="list-group-item">
                        <h5>{{$comment->created_at}} by {{$comment->user->name}}</h5>
                        <div>
                            {{$comment->content}}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">发表评论</div>

            <!-- List group -->
            <ul class="list-group">
                <form action="{{ url('api/commentAdd') }}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="post_id" value="{{$post->id}}"/>
                    @if ($errors->has('content'))
                        <span class="help-block alert-danger">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                    @endif
                    <li class="list-group-item">
                        <textarea name="content" class="form-control" rows="10"></textarea>

                        <button class="btn btn-default" type="submit">提交</button>
                    </li>
                </form>

            </ul>
        </div>

    </div><!-- /.blog-main -->

@endsection
