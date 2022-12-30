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
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->integer('user_id');
            $table->string('nota_awal')->nullable();
            $table->string('nota_akhir')->nullable();
            $table->integer('total_nota')->nullable();
            $table->integer('total_nota_hapus')->nullable();
            $table->bigInteger('modal_awal')->nullable();
            $table->bigInteger('cash')->nullable();
            $table->bigInteger('transfer')->nullable();
            $table->bigInteger('gross_sales')->nullable();
            $table->bigInteger('diskon')->nullable();
            $table->bigInteger('ppn')->nullable();
            $table->bigInteger('net_sales')->nullable();
            $table->bigInteger('rata_rata')->nullable();
            $table->bigInteger('pengeluaran')->nullable();
            $table->bigInteger('total_uang_tunai')->nullable();
            $table->bigInteger('selisih')->nullable();
            $table->string('status')->default('open');
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
        Schema::dropIfExists('closings');
    }
};
