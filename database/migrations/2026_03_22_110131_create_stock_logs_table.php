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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('branch_id');
        
            $table->decimal('qty_change', 12, 2);
            $table->decimal('qty_before', 12, 2);
            $table->decimal('qty_after', 12, 2);
        
            $table->enum('type', ['IN', 'OUT']);
        
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
        
            $table->unsignedBigInteger('created_by')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
