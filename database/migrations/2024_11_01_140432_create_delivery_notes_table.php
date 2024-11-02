<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNotesTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_officer_id')->nullable();
            $table->unsignedBigInteger('room_officer_id')->nullable();
            $table->unsignedBigInteger('warehouse_officer_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('nomor_surat', 255);
            $table->dateTime('tanggal_pengiriman')->nullable();
            $table->enum('ship_to', ['gudang kota', 'gudang unaaha', 'gudang kolaka'])->default('gudang kota');
            $table->string('nomor_plat', 255);
            $table->string('nama_driver', 255);
            $table->enum('palka', ['palka 1', 'palka 2'])->default('palka 1');
            $table->enum('status', ['dibuat', 'dikirim', 'sampai', 'selesai'])->default('dibuat');
            $table->dateTime('tanggal_sampai')->nullable();
            $table->dateTime('tanggal_bongkar')->nullable();
            $table->boolean('print')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('field_officer_id')->references('id')->on('officers')->onDelete('set null');
            $table->foreign('room_officer_id')->references('id')->on('officers')->onDelete('set null');
            $table->foreign('warehouse_officer_id')->references('id')->on('officers')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_notes');
    }
}
