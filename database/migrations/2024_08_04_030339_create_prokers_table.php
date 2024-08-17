<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProkersTable extends Migration
{
    public function up()
    {
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->enum('divisi', ['pendidikan', 'litbang', 'kominfo', 'rsdm']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prokers');
    }
}

