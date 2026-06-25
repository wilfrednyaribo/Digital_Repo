<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('document_type')->nullable()->after('description');
            $table->string('cover_image')->nullable()->after('file_size');
            $table->decimal('rating', 2, 1)->nullable()->default(0)->after('cover_image');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'cover_image', 'rating']);
        });
    }
};