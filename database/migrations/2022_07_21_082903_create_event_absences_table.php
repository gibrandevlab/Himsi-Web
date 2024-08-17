<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEventAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_absence', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            // $table->uuid('id')->default($uuid)->primary();
            $table->id();
            $table->string("email", 150)->nullable();
            $table->string("nim", 150)->nullable();
            $table->string("university", 150)->nullable();
            $table->boolean("isPaidOff", 150)->nullable();
            // $table->foreignUuid("event_id")->nullable()->references("id")->on("event")->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('event_id')->constrained('event')->onUpdate('cascade')->onDelete('cascade');
            $table->enum("status", array("sakit", "ijin", "absen", "hadir"))->default("absen");
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_absence');
    }
}
