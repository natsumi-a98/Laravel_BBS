<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//投稿されたページを表示するページ
use Illuminate\Support\Facades\DB;
//Postモデルを参照
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Rules\NoWhitespaceOnly;


class PostController extends Controller
{
    //indexメソッド
    public function index()
    {
        // ユーザー情報を含めて投稿データを取得
        $list = Post::with('user')
            ->get()
            ->map(function ($post) {
                // latest_timestamp 属性を設定
                $post->latest_timestamp = max($post->created_at, $post->updated_at);
                return $post;
            })
            // latest_timestamp で降順に並び替え
            ->sortByDesc('latest_timestamp');

        // view ファイル index.blade.php の呼び出し
        return view('posts.index', ['lists' => $list]);
    }

    //crateFormメソッド
    public function createForm()
    {
        return view('posts.createForm');
    }

    //createメソッド
    public function create(Request $request)
    {
        // バリデーション
        $request->validate([
            'newPost' => ['required', 'string', 'max:100', new NoWhitespaceOnly],
        ], [
            'newPost.required' => '投稿内容を入力してください。',
            'newPost.string' => '投稿内容は文字列である必要があります。',
            'newPost.max' => '投稿内容は100文字以内である必要があります。',
            'newPost.no_whitespace_only' => '投稿内容を入力してください。',
        ]);

        // Eloquentを使用して新しい投稿を作成
        Post::create([
            'contents' => $request->input('newPost'),
            'user_id' => Auth::id(), // 現在のログインユーザーのIDを取得
            'user_name' => Auth::user()->name // ユーザー名を取得
        ]);

        return redirect('/index'); // リダイレクト
    }



    //updateFormメソッド
    public function updateForm($id)
    {
        $post = DB::table('posts')
            ->where('id', $id)
            ->first();
        return view('posts.updateForm', ['post' => $post]);
    }

    //updateメソッド
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
            'upPost' => ['required', 'string', 'max:100', new NoWhitespaceOnly],
        ], [
            'id.required' => '投稿IDがありません。',
            'id.exists' => '指定された投稿IDは存在しません。',
            'upPost.required' => '投稿内容を入力してください。',
            'upPost.string' => '投稿内容は文字列である必要があります。',
            'upPost.max' => '投稿内容は100文字以内である必要があります。',
            'upPost.no_whitespace_only' => '投稿内容を入力してください。',
        ]);

        $post = Post::findOrFail($request->input('id'));
        $post->update(['contents' => $request->input('upPost')]);

        return redirect('/index')->with('success', '投稿を更新しました');
    }


    //deleteメソッド
    public function delete($id)
    {
        DB::table('posts')
            ->where('id', $id)
            ->delete();

        return redirect('/index');
    }

    //ミドルウェア読み込みの記述
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 曖昧検索メソッドの修正
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // キーワードに基づいて検索
        $results = Post::query()
            ->when($keyword !== null, function ($query) use ($keyword) {
                // キーワードが空欄の場合は空として扱う
                if (trim($keyword) === '') {
                    return $query;
                }

                // キーワードに基づいて投稿内容を曖昧検索
                return $query->where('contents', 'like', '%' . $keyword . '%');
            })
            ->with('user')
            ->get()
            ->map(function ($post) {
                $post->latest_timestamp = max($post->created_at, $post->updated_at);
                return $post;
            })
            ->sortByDesc('latest_timestamp');

        // 検索結果が0件の場合
        if ($results->isEmpty()) {
            return view('posts.search-results', [
                'lists' => null,
                'message' => '検索結果は0件です。',
            ]);
        }

        return view('posts.search-results', [
            'lists' => $results,
            'message' => null,
        ]);
    }

}
