<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            // $table->uuid('id')->default($uuid)->primary();
            $table->id();
            $table->foreignId('event_note_id')->nullable()->constrained('event_note')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignUuid("event_note_id")->nullable()->references("id")->on("event_note")->nullOnDelete()->cascadeOnUpdate();
            $table->longText("note");
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
        Schema::dropIfExists('note');
    }
}
