<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')
                    ->comment('unique code')
                    ->unique();
            $table->string('type')
                    ->comment('ministry, division, directorate, office, etc.');
            $table->string('layer')
                    ->nullable();
            $table->string('origin')
                    ->nullable(); 
            $table->integer('level')
                    ->default(0)
                    ->comment('hierarchical level of the organization');
            $table->json('metadata')
                    ->nullable()
                    ->comment('additional metadata for the organization');
            $table->string('status')
                    ->default('active')
                    ->comment('status of the organization (active, inactive, etc.)');
            $table->timestamps();           
            $table->foreignId('parent_id')->nullable()->references('id')->on('organizations');

            //Indexes
            $table->index(['type', 'layer', 'status', 'parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('organizations');
    }
};