<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policy_articles', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('summary');
            $table->json('content');
            $table->string('status', 20)->default('guidance');
            $table->unsignedInteger('version')->default(1);
            $table->boolean('is_public')->default(false);
            $table->timestamp('effective_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['is_public', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policy_articles');
    }
};
