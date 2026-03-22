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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('branch_id'); // sementara manual dulu
        
            $table->decimal('qty', 12, 2)->default(0);
        
            $table->timestamps();
        
            $table->unique(['material_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
