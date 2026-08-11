<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // e.g. "Private Starter"
            $table->string('slug')->unique();              // e.g. "private-starter"
            $table->string('category');                    // "private" | "business"
            $table->string('portfolio_label');             // e.g. "bis 25.000 CHF Portfolio"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pricing_package_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_package_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('type', ['digital', 'onsite']);   // "digital" | "onsite"
            $table->string('label');                       // "Digital Package" | "On-Site Service"
            $table->unsignedInteger('price_chf');          // price in CHF (no decimals)
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_only_option')->default(false); // Business Enterprise edge case
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pricing_option_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_package_option_id')
                  ->constrained('pricing_package_options')
                  ->cascadeOnDelete();

            $table->string('feature');                     // bullet point text
            $table->boolean('is_inherited')->default(false); // true = "from Digital Package"
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_option_features');
        Schema::dropIfExists('pricing_package_options');
        Schema::dropIfExists('pricing_packages');
    }
};