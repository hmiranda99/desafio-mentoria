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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_hash', 200)->index();
            $table->string('status', 60)->index();
            $table->float('value', 10, 2);
            $table->unsignedInteger('user_payer_id');
            $table->foreign('user_payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_payee_id')->nullable()->default(null)->index();
            $table->unsignedInteger('transaction_type');
            $table->foreign('transaction_type')->references('id')->on('transactions_types')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
};
