<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->unsignedTinyInteger('discount_percent');
                $table->string('allowed_package')->nullable();
                $table->boolean('requires_grant')->default(false);
                $table->boolean('is_active')->default(true);
                $table->string('notes')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('coupon_grants')) {
            Schema::create('coupon_grants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
                $table->string('email');
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->timestamp('expires_at');
                $table->timestamp('used_at')->nullable();
                $table->timestamps();

                $table->index(['email', 'coupon_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_grants');
        Schema::dropIfExists('coupons');
    }
};
