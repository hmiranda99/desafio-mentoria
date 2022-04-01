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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at', 'transaction_at']);
            $table->renameColumn('owner_payer_id', 'user_payer_id');
            $table->foreign('user_payer_id')->references('id')->on('users')->onDelete('cascade')->change();
            $table->renameColumn('owner_payee_id', 'user_payee_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('user_payee_id')->nullable()->default(null)->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
