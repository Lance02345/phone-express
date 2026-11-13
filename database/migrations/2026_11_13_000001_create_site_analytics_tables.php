<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_page_views', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id');
            $table->uuid('session_id');
            $table->boolean('is_new_visitor')->default(false);
            $table->boolean('is_entry')->default(false);
            $table->string('path', 255);
            $table->string('query', 255)->nullable();
            $table->string('search_term', 100)->nullable();
            $table->string('route_name', 100)->nullable();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->string('referrer_host', 150)->nullable();
            $table->string('source', 30);
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('device', 10);
            $table->string('browser', 30);
            $table->string('os', 30);
            $table->char('country', 2)->nullable();
            $table->date('local_date');
            $table->unsignedTinyInteger('local_hour');
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
            $table->index(['local_date', 'is_entry']);
            $table->index('session_id');
            $table->index('visitor_id');
            $table->index('product_variant_id');
        });

        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id');
            $table->uuid('session_id');
            $table->string('name', 30);
            $table->string('path', 255);
            $table->string('label', 255)->nullable();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->date('local_date');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['local_date', 'name']);
            $table->index('session_id');
            $table->index('product_variant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('analytics_page_views');
    }
};
