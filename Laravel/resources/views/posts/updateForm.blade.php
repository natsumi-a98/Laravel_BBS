@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="page-header">投稿内容を更新する</h2>
  {!! Form::open(['url' => '/post/update']) !!}
  <div class="form-group">
    {!! Form::hidden('id', $post->id) !!}
    {!! Form::input('text', 'upPost', $post->contents, ['required', 'class' => 'form-control']) !!}
  </div>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
  </div>
  @endif
  <div class="col-md-3">
    <div class="form-group">
      <button type="submit" class="btn btn-primary pull-right">更新</button>
      <a href="/index" class="btn btn-success">戻る</a>
    </div>
  </div>
  {!! Form::close() !!}
</div>

@endsection
