@extends('layouts.app')

@section('content')

<div class="container">
  @auth
  <p class="pull-right"><a class="btn btn-success" href="/create-form">投稿する</a></p>
@endauth
  <form action="{{ route('search') }}" method='post'>
    @csrf
    <input type="text" name="keyword" placeholder="キーワードを入力">
    <button type="submit">検索</button>
  </form>

  <table class="table table-hover">
    @foreach ($lists as $list)
    <tr>
    <td>
    @if($list->user)
    {{ $list->user->name }}
    @endif
    </td>
    <td>{{ $list->contents }}</td>
    <td>{{ $list->latest_timestamp }}</td>
    <td class="text-right">
    @auth
    @if ($list->user_id === auth()->id())
    <a class="btn btn-primary" href="/post/{{ $list->id }}/update-form">更新</a>
    <a class="btn btn-danger" href="/post/delete/{{ $list->id }}" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a>
    @endif
    @endauth
    </td>
    </tr>
  @endforeach
  </table>
</div>

@endsection
