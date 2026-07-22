<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_invitations', function (Blueprint $table) {
            $table->string('subject')->nullable();
            $table->text('custom_message')->nullable();
            $table->timestamp('revoked_at')->nullable();
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->boolean('is_manually_managed')->default(false);
        });

        Schema::create('staff_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 80);
            $table->string('subject_type', 120)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('changes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_activity_logs');
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('is_manually_managed');
        });
        Schema::table('staff_invitations', function (Blueprint $table) {
            $table->dropColumn(['subject', 'custom_message', 'revoked_at']);
        });
    }
};
