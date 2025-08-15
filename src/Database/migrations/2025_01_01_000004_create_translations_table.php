<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('table_name'); // e.g., 'employees', 'departments'
            $table->unsignedBigInteger('model_id'); // Foreign key to the model record
            $table->string('locale'); // e.g., 'en', 'bn', 'fr'
            $table->string('attribute'); // e.g., 'name', 'description'
            $table->text('value'); // Translated value
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['table_name', 'model_id']);
            $table->index(['table_name', 'locale', 'attribute']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
};