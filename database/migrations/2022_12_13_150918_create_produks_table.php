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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('nama');
            $table->foreignId('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->foreignId('satuan_id')->references('id')->on('satuans')->onDelete('cascade');
            $table->bigInteger('stok')->default(0);
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
        Schema::dropIfExists('produks');
    }
};
