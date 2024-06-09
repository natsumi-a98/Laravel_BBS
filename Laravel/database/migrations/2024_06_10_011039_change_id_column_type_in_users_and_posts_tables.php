<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeIdColumnTypeInUsersAndPostsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // postsテーブルのuser_idに設定されている外部キー制約を一旦削除
        Schema::table('posts', function (Blueprint $table) {
            // get foreign keys on the posts table
            $keys = DB::select(DB::raw('SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = "posts" AND COLUMN_NAME = "user_id" AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL'));
            if (count($keys) > 0) {
                $table->dropForeign(['user_id']);
            }
        });

        // usersテーブルのidカラムの型をbigintからintに変更
        Schema::table('users', function (Blueprint $table) {
            $table->integer('id', false, true)->change();
        });

        // postsテーブルのuser_idカラムとidカラムの型をbigintからintに変更
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('user_id', false, true)->change();
            $table->integer('id', false, true)->change();
        });

        // カラムの長さを11に変更
        DB::statement('ALTER TABLE users MODIFY id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE posts MODIFY user_id INT(11) UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE posts MODIFY id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT');

        // postsテーブルのuser_idに対して外部キー制約を再追加
        Schema::table('posts', function (Blueprint $table) {
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
        // postsテーブルのuser_idに設定されている外部キー制約を再度削除
        Schema::table('posts', function (Blueprint $table) {
            // get foreign keys on the posts table
            $keys = DB::select(DB::raw('SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = "posts" AND COLUMN_NAME = "user_id" AND CONSTRAINT_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL'));
            if (count($keys) > 0) {
                $table->dropForeign(['user_id']);
            }
        });

        // postsテーブルのuser_idカラムとidカラムの型をintからbigintに変更
        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->bigInteger('id')->unsigned()->change();
        });

        // usersテーブルのidカラムの型をintからbigintに変更
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->change();
        });

        // postsテーブルのuser_idに対して外部キー制約を再追加
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}

