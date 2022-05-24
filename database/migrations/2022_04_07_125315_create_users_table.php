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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('email', 80)->unique()->index();
            $table->string('password', 80);
            $table->string('cpf', 14)->unique()->nullable()->default(null)->index();
            $table->string('cnpj', 18)->unique()->nullable()->default(null)->index();
            $table->string('user_entity', 10)->index();
            $table->datetime('created_at')->index();
            $table->datetime('deleted_at')->nullable()->default(null)->index();
            $table->datetime('updated_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
