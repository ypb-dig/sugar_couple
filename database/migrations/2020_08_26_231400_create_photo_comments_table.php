<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_comments', function (Blueprint $table) {
            $table->id();
            $table->integer("owner")->nullable();
            $table->integer("by")->nullable();
            $table->string("photo_uid")->nullable();
            $table->string("comment")->nullable();
            $table->boolean("visible")->default(true);
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
        Schema::dropIfExists('photo_comments');
    }
}
