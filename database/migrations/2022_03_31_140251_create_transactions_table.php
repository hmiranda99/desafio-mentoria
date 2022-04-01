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
            $table->datetime('transaction_at')->index();
            $table->string('status', 60)->index();
            $table->float('value', 10, 2);
            $table->unsignedInteger('owner_payer_id');
            $table->foreign('owner_payer_id')->references('id')->on('owners')->onDelete('cascade');
            $table->unsignedInteger('owner_payee_id')->nullable()->default(null)->index();
            $table->unsignedInteger('transaction_type');
            $table->foreign('transaction_type')->references('id')->on('transactions_types')->onDelete('cascade');
            $table->timestamps();
            // created_at ->
            // deleted_at ->
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
