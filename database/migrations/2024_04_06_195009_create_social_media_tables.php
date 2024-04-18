<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('address');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('namaAlbum');
            $table->dateTime('tanggaldibuat');
            $table->string('deskripsi')->nullable();;
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->string('judulfoto');
            $table->text('deskripsifoto');
            $table->dateTime('tanggalunggah');
            $table->string('image');
            $table->unsignedBigInteger('album_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('komentarfoto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fotoid');
            $table->unsignedBigInteger('userid');
            $table->text('isikomentar');
            $table->dateTime('tanggalkomentar');
            $table->foreign('fotoid')->references('id')->on('fotos')->onDelete('cascade');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('likefoto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fotoid');
            $table->unsignedBigInteger('userid');
            $table->foreign('fotoid')->references('id')->on('fotos')->onDelete('cascade');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('follower_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['user_id', 'follower_id']); // Menambahkan kunci unik
        });

        Schema::create('followings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('following_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['user_id', 'following_id']); // Menambahkan kunci unik
        });

        Schema::create('save_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('photo_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('photo_id')->references('id')->on('fotos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('save_photos');
        Schema::dropIfExists('followings');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('likefoto');
        Schema::dropIfExists('komentarfoto');
        Schema::dropIfExists('fotos');
        Schema::dropIfExists('albums');
    }
};
