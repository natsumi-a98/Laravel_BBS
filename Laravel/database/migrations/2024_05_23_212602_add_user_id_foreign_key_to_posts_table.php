<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class AddUserIdForeignKeyToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //user_idのカラムを追加
            $table->unsignedBigInteger('user_id')->nullable();
            //外部キー制約の追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //外部キー制約の削除
            $table->dropForeign(['user_id']);
            //ユーザーIDのカラムの削除
            $table->dropColumn('user_id');
        });
    }
}
