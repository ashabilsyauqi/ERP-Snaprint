<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('unit');

            $table->timestamps();

            // optional tapi recommended
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};