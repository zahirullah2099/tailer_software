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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('taken_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Shirt Measurements
            $table->decimal('chest', 5, 2)->nullable();
            $table->decimal('shoulder', 5, 2)->nullable();
            $table->decimal('sleeve', 5, 2)->nullable();
            $table->decimal('neck', 5, 2)->nullable();
            $table->decimal('shirt_length', 5, 2)->nullable();

            // Shalwar Measurements
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('hip', 5, 2)->nullable();
            $table->decimal('shalwar_length', 5, 2)->nullable();
            $table->decimal('bottom_width', 5, 2)->nullable();

            // Enum-backed fields
            $table->string('collar')->nullable();
            $table->string('cuff')->nullable();
            $table->string('pocket_type')->nullable();

            $table->text('fitting_notes')->nullable();

            $table->boolean('is_default')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
