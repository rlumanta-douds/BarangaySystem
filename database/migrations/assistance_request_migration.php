<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the table already exists before creating it
        if (!Schema::hasTable('assistance_requests')) {
            Schema::create('assistance_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resident_id')->constrained();
                $table->string('assistance_type');
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('status')->default('Pending');
                $table->text('reason');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('assistance_requests');
    }
};