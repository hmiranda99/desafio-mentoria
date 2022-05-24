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
        Schema::create('transactions_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 100)->index();
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
        Schema::dropIfExists('transactions_types');
    }
};
