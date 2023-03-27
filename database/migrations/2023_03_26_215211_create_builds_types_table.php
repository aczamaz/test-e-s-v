<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('builds_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('build_id');
            $table->foreign('build_id')->nullable()
                ->references('id')
                ->on('builds')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->nullable()
                ->references('id')
                ->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objects_types');
    }
};
