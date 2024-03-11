<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('short_description');
            $table->longText('description');
            $table->foreignId('channels');
            $table->foreignId('default_category');
            $table->string('categorys')->nullable();
            $table->string('tags');
            $table->string('author');
            $table->foreignId('author_id')->default(0);
            $table->string('src');
            $table->string('locale');
            $table->boolean('status');
            $table->boolean('allow_comments');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->dateTime('published_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};
