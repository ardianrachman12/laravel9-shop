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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->string('status');
            $table->string('kode');
            $table->decimal('total_berat');
            $table->integer('total_harga');
            $table->integer('ongkir');
            $table->string('kurir');
            $table->string('service');
            $table->integer('grand_total');
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('alamat_detail');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('status_pembayaran');
            $table->string('resi');
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
        Schema::dropIfExists('orders');
    }
};
