<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payer');
            $table->unsignedBigInteger('payee');
            $table->decimal('value', 8,2);
            $table->enum('status', ['0','1','2'])->default('0')->comment(('0: Pendente, 1: Pago, 2: Cancelado.'));
            $table->timestamps();

            $table->foreign('payer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payee')->references('id')->on('users')->onDelete('cascade');
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
}
