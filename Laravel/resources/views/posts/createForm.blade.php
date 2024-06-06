@extends('layouts.app')
@section('content')

<div class="container">
  <h2 class="page-header">新しく投稿する</h2>
  {!! Form::open(['url' => 'post/create']) !!}
  <div class="form-group">
    {!! Form::input('text', 'newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '投稿内容']) !!}
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
      <button type="submit" class="btn btn-success">追加</button>
      <a href="/index" class="btn btn-success">戻る</a>
    </div>
  </div>
  {!! Form::close() !!}
</div>

@endsection
