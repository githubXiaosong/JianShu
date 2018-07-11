@extends('layouts.main')

@section('content')

    <div class="col-sm-8 blog-main">
        <form action="{{ url('api/postEdit') }}" method="POST">

            <input type="hidden" name="id" value="{{ $post->id }}">

            {{ csrf_field() }}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题" value="{{ $post->title }}">
            </div>
            @if ($errors->has('title'))
                <span class="help-block alert-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif

            <div class="form-group">
                <label>内容</label>
                <textarea id="content" name="content" class="form-control" style="height:400px;max-height:500px;"
                          placeholder="这里是内容">{!! $post->content !!}</textarea>
            </div>
            @if ($errors->has('content'))
                <span class="help-block alert-danger">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
            @endif

            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>
    </div><!-- /.blog-main -->

@endsection