<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_view_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->date('metric_date');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();

            $table->unique(['product_variant_id', 'metric_date']);
            $table->index(['metric_date', 'view_count']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_view_metrics');
    }
};
