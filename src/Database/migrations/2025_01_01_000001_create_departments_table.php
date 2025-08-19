<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreignId('parent_id')->nullable()->references('id')->on('departments');

            // Indexes
            $table->index(['organization_id', 'parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};