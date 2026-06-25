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
        Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Who uploaded it
    
    $table->string('title');
    $table->string('author_creator')->nullable(); // Book author or record creator
    $table->text('description')->nullable();
    
    // File Details
    $table->string('file_path');
    $table->string('file_type'); // pdf, docx, jpg, etc.
    $table->bigInteger('file_size'); // in bytes
    
    $table->boolean('is_public')->default(false); // false = admin only, true = everyone
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
