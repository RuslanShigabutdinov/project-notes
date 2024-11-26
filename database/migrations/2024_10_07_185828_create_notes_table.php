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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->text('image')->nullable();
            $table->string('text_color')->default('#333');
            $table->string('note_color')->default('#fff');
            $table->string('line_color')->default('#395bf5');
            $table->foreignId('creator_id')->constrained(
                table: 'users', indexName: 'creator_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
