<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $uuid = DB::raw("(UUID())");
            // $table->uuid('id')->default($uuid)->primary();
            $table->id();
            $table->string("name", 200);
            $table->longText("address");
            $table->bigInteger("nim")->unique();
            $table->boolean("status")->default(true);
            $table->string("phoneNumber", 15)->unique();
            $table->string("image")->nullable();
            $table->string("occupation", 30);
            $table->string("token", 8)->unique()->nullable();
            $table->string("location")->nullable();
            $table->string("periode", 10);
            // $table->foreignId("user_id")->references("id")->on("user")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('user')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('member');
    }
}
