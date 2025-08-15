<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained();
            $table->foreignId('organization_id')->constrained();
            $table->string('name');
            $table->string('employee_id')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->date('joining_date');
            $table->foreignId('reporting_to')->nullable()->references('id')->on('employees');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};