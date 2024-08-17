<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proker', function (Blueprint $table) {
            $table->id();
            $table->enum('divisi', ['pendidikan', 'litbang', 'kominfo', 'rsdm']);
            $table->text('fotokegiatan')->nullable();
            $table->string('title', 40)->nullable();
            $table->text('content')->nullable();
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
        Schema::dropIfExists('proker');
    }
}
