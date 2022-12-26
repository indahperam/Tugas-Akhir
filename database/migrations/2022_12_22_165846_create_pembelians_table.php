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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->bigInteger('supplier_id');
            $table->bigInteger('total');
            $table->bigInteger('diskon');
            $table->bigInteger('diskon_total');
            $table->bigInteger('ppn');
            $table->bigInteger('ppn_total');
            $table->bigInteger('grand_total');
            $table->string('status');
            $table->boolean('active');
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
        Schema::dropIfExists('pembelians');
    }
};
