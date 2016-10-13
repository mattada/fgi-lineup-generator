<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['article', 'page']);
            $table->string('title');
            $table->string('title_slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('preview')->nullable();
            $table->text('content')->nullable();
            $table->string('author')->nullable();
            $table->enum('subscription_group', ['fgi', 'euro', 'pro'])->nullable();
            $table->string('section')->nullable(); //TODO: Name other sections
            $table->boolean('featured')->nullable();
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
        Schema::drop('contents');
    }
}
