<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('featured_rank')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'name']);
            $table->index(['status', 'published_at']);
            $table->index(['category_id', 'status']);
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('legacy_phone_id')->nullable()->constrained('phones')->nullOnDelete();
            $table->string('sku')->unique();
            $table->string('label');
            $table->unsignedInteger('storage_gb')->nullable();
            $table->unsignedInteger('ram_gb')->nullable();
            $table->string('colour')->nullable();
            $table->string('connectivity')->nullable();
            $table->string('condition', 20)->default('new');
            $table->unsignedBigInteger('price_minor')->nullable();
            $table->char('currency', 3)->default('KES');
            $table->boolean('quote_required')->default(false);
            $table->boolean('payment_plan_eligible')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('source', 40);
            $table->string('source_key', 120);
            $table->timestamps();

            $table->unique('legacy_phone_id');
            $table->unique(['source', 'source_key']);
            $table->index(['is_active', 'price_minor']);
            $table->index(['storage_gb', 'ram_gb']);
        });

        DB::statement('ALTER TABLE product_variants ADD CONSTRAINT product_variants_price_or_quote_check CHECK (price_minor IS NOT NULL OR quote_required = true)');
        DB::statement('ALTER TABLE product_variants ADD CONSTRAINT product_variants_price_non_negative_check CHECK (price_minor IS NULL OR price_minor >= 0)');

        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('disk')->default('public_root');
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->string('checksum')->nullable();
            $table->timestamps();

            $table->unique(['product_variant_id', 'path']);
            $table->index(['product_id', 'sort_order']);
        });

        Schema::create('specification_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('unit')->nullable();
            $table->string('value_type', 20)->default('text');
            $table->boolean('is_filterable')->default(false);
            $table->timestamps();
        });

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('specification_definition_id')->constrained()->cascadeOnDelete();
            $table->text('value');
            $table->timestamps();

            // Keep the identifier below MySQL/MariaDB's 64-character limit.
            $table->unique(
                ['product_id', 'specification_definition_id'],
                'product_specs_product_definition_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('specification_definitions');
        Schema::dropIfExists('product_media');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
    }
};
