<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url');          // S3 public URL
            $table->string('duration')->nullable(); // e.g. "18:42"
            $table->string('tag')->nullable();      // e.g. "Einführung"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot: which packages have access to which videos
        Schema::create('course_video_package', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_video_id')
                  ->constrained('course_videos')->cascadeOnDelete();
            $table->foreignId('pricing_package_id')
                  ->constrained('pricing_packages')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_video_package');
        Schema::dropIfExists('course_videos');
    }
};