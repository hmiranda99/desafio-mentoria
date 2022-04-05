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
        Schema::create('owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('email', 80)->unique()->index();
            $table->string('password', 80);
            $table->string('cpf', 11)->unique()->nullable()->default(null)->index();
            $table->string('cnpj', 14)->unique()->nullable()->default(null)->index();
            $table->string('owner_entity', 10)->index();
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
        Schema::dropIfExists('owners');
    }
};
