<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('inventory_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();
            $table->foreignId('location_id')->constrained()->restrictOnDelete();
            $table->string('tracking_mode', 20)->default('unknown');
            $table->string('status', 20)->default('unknown');
            $table->unsignedInteger('quantity_on_hand')->nullable();
            $table->unsignedInteger('quantity_reserved')->nullable();
            $table->string('source', 40)->default('manual_import');
            $table->string('source_key', 160)->nullable();
            $table->timestamp('observed_at')->nullable();
            $table->timestamps();

            $table->unique(['product_variant_id', 'location_id']);
            $table->unique(['source', 'source_key']);
            $table->index(['status', 'observed_at']);
        });

        DB::statement("ALTER TABLE inventory_levels ADD CONSTRAINT inventory_levels_tracking_mode_check CHECK (tracking_mode IN ('unknown', 'coarse', 'exact'))");
        DB::statement("ALTER TABLE inventory_levels ADD CONSTRAINT inventory_levels_status_check CHECK (status IN ('unknown', 'available', 'limited', 'out_of_stock'))");
        DB::statement("ALTER TABLE inventory_levels ADD CONSTRAINT inventory_levels_exact_quantities_check CHECK (tracking_mode <> 'exact' OR (quantity_on_hand IS NOT NULL AND quantity_reserved IS NOT NULL AND quantity_reserved <= quantity_on_hand))");
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_levels');
        Schema::dropIfExists('locations');
    }
};
