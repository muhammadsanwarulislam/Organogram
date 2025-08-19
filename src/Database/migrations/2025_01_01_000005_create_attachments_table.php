<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type'); // Model class (e.g., App\Models\Employee)
            $table->unsignedBigInteger('attachable_id'); // Model ID
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->string('extension');
            $table->integer('size')->comment('Size in bytes');
            $table->string('path');
            $table->string('disk')->default('public');
            $table->string('hash')->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['attachable_type', 'attachable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
};