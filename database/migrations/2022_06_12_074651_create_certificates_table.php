<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            // $table->uuid('id')->default($uuid)->primary();
            $table->id();
            $table->string("link");
            $table->foreignId('event_id')->constrained('event')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignUuid("event_id")->nullable()->references("id")->on("event")->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('certificate');
    }
}
