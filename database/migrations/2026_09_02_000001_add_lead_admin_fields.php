<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                if (! Schema::hasColumn('leads', 'status')) {
                    $table->string('status')->default('new')->after('source');
                }
                if (! Schema::hasColumn('leads', 'notes')) {
                    $table->text('notes')->nullable()->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                if (Schema::hasColumn('leads', 'notes')) {
                    $table->dropColumn('notes');
                }
                if (Schema::hasColumn('leads', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
