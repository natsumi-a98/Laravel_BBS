@extends('layouts.app')

@section('content')

<div class="container">
  <h2>検索結果</h2>

  <p class="pull-right"><a href="/index" class="btn btn-success">戻る</a></p>

  @if (isset($message))
    <p>{{ $message }}</p>
  @endif

  @if (isset($lists) && count($lists) > 0)
    <table class="table table-hover">
      @foreach ($lists as $list)
        <tr>
          <td>
          @if($list->user)
            {{ $list->user->name }}
          @else
            ユーザーが存在しません。
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
  @endif
</div>

@endsection
