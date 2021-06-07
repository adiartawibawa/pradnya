<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->foreignId('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->foreignId('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
            $table->unique(['slug', 'user_id']);
        });

        Schema::create('posts_tags', function (Blueprint $table) {
            $table->foreignId('post_id');
            $table->foreignId('tag_id');
            $table->unique(['post_id', 'tag_id']);
        });

        Schema::create('posts_topics', function (Blueprint $table) {
            $table->foreignId('post_id');
            $table->foreignId('topic_id');
            $table->unique(['post_id', 'topic_id']);
        });

        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->index();
            $table->string('ip')->nullable();
            $table->text('agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });

        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->string('ip')->nullable();
            $table->text('agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('posts_tags');
        Schema::dropIfExists('posts_topics');
        Schema::dropIfExists('views');
        Schema::dropIfExists('visits');
    }
}
