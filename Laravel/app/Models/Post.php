<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    // リレーションシップを定義する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // タイムスタンプを自動的に管理する
    public $timestamps = true;

    protected $fillable = [
        'contents',
        'user_id',
        'user_name',
    ];

    // latest_timestamp アクセサを定義する
    public function getLatestTimestampAttribute()
    {
        return max($this->created_at, $this->updated_at);
    }
}
