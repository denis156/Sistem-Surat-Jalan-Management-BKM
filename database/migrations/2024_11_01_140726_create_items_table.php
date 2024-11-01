<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_note_id');
            $table->string('name_item', 255);
            $table->integer('quantity');
            $table->enum('description', ['utuh', 'robek kapal', 'basah kapal', 'robek truck', 'basah truck', 'robek pbm', 'basah pbm', 'karung lebih', 'karung kurang'])->default('utuh');
            $table->timestamps();

            $table->foreign('delivery_note_id')->references('id')->on('delivery_notes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
